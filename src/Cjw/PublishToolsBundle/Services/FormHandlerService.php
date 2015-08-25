<?php
/**
 * File containing the FormHandlerService class
 *
 * @copyright Copyright (C) 2007-2015 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @filesource
 */

namespace Cjw\PublishToolsBundle\Services;

use Symfony\Component\Templating\EngineInterface;

class FormHandlerService
{
    const separator = '___';
    protected $container;
    protected $em;
    protected $mailer;
    protected $templating;
    protected $formBuilderService;

    /**
     * init the needed services
     */
    public function __construct( $container, $em, \Swift_Mailer $mailer, EngineInterface $templating, $FormBuilderService )
    {
        $this->container = $container;
        $this->em = $em;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->formBuilderService = $FormBuilderService;
    }

    /**
     * Adding collected form content to the old ez info collector
     *
     * @param mixed $formDataObj
     * @param array $handlerConfigArr
     * @param mixed $handlerParameters
     *
     * @return bool false
     */
    public function addToInfoCollectorHandler( $formDataObj, $handlerConfigArr, $handlerParameters, $form )
    {
        $content = $handlerParameters['content'];
        $contentType = $handlerParameters['contentType'];

        $formBuilderService = $this->container->get( 'cjw_publishtools.formbuilder.functions' );

        $timestamp = time();

        // get table from db (services.yml)
        $ezinfocollection = $this->container->get( 'db_table_ezinfocollection' );

        // add new collection
        $ezinfocollectionRow = new $ezinfocollection();

        $ezinfocollectionRow->set( 'contentobject_id', $handlerParameters['contentObjectId'] );
        $ezinfocollectionRow->set( 'user_identifier', '' );
        $ezinfocollectionRow->set( 'creator_id', $handlerParameters['currentUserId'] );
        $ezinfocollectionRow->set( 'created', $timestamp );
        $ezinfocollectionRow->set( 'modified', $timestamp );

        $this->em->persist( $ezinfocollectionRow );
        $this->em->flush();

        $informationcollectionId = $ezinfocollectionRow->getId();

        // get table from db (services.yml)
        $ezinfocollectionAttribute = $this->container->get( 'db_table_ezinfocollection_attribute' );

        // add collection attribute
        foreach( $formDataObj as $key => $attribute )
        {
            $keyArr = explode( FormHandlerService::separator, $key );
            $fieldType = $keyArr['0'];
            $fieldIdentifier = $keyArr['1'];

            $data_float = 0;
            $data_int = 0;
            $data_text = '';

            switch ( $fieldType )
            {
                case 'ezxml':
                    $data_text =  $formBuilderService->newEzXmltextSchema( $attribute );
                    break;

                default:
                    $data_text = (string) $attribute;
            }

            $ezinfocollectionAttributeRow = new $ezinfocollectionAttribute();
            $ezinfocollectionAttributeRow->set( 'contentobject_id', $handlerParameters['contentObjectId'] );
            $ezinfocollectionAttributeRow->set( 'informationcollection_id', $informationcollectionId );
            $ezinfocollectionAttributeRow->set( 'contentclass_attribute_id', $contentType[$fieldIdentifier]->id );
            $ezinfocollectionAttributeRow->set( 'contentobject_attribute_id', $content->getField($fieldIdentifier)->id );
            $ezinfocollectionAttributeRow->set( 'data_float', $data_float );
            $ezinfocollectionAttributeRow->set( 'data_int', $data_int );
            $ezinfocollectionAttributeRow->set( 'data_text', $data_text );

            $this->em->persist( $ezinfocollectionAttributeRow );
            $this->em->flush();
        }

        return false;
    }

    /**
     * Builds and sending an email, renders the email body with an twig template
     *
     * @param mixed $formDataObj
     * @param array $handlerConfigArr
     * @param mixed $handlerParameters
     *
     * @return bool false
     */
    public function sendEmailHandler( $formDataObj, $handlerConfigArr, $handlerParameters, $form )
    {
        $content = false;
        if ( isset( $handlerParameters['content'] ) )
        {
            $content = $handlerParameters['content'];
        }

        $location = false;
        if ( isset( $handlerParameters['location'] ) )
        {
            $location = $handlerParameters['location'];
        }

        $formDataArr = $this->getFormDataArray( $formDataObj );

        $template = false;
        if ( isset( $handlerConfigArr['template'] ) )       // ToDo: more checks
        {
            $template = $this->formBuilderService->getTemplateOverride( $handlerConfigArr['template'] );
        }

        $subject = false;
        if ( isset( $handlerConfigArr['email_subject'] ) )        // ToDo: more checks
        {
            if ( substr( $handlerConfigArr['email_subject'], 0, 1 ) === '@' )
            {
                $subject_mapping = substr( $handlerConfigArr['email_subject'], 1 );
                if ( isset( $formDataArr[$subject_mapping]['value'] ) )
                {
                    $subject = $formDataArr[$subject_mapping]['value'];
                }
            }
            else
            {
                $subject = $handlerConfigArr['email_subject'];
            }
// ToDo: subject mapping / static (intl)
        }

        $from = false;
        if ( isset( $handlerConfigArr['email_sender'] ) )
        {
            if ( substr( $handlerConfigArr['email_sender'], 0, 1 ) === '@' )
            {
                $email_sender_mapping = substr( $handlerConfigArr['email_sender'], 1 );
                if ( isset( $formDataArr[$email_sender_mapping]['value'] ) )
                {
                    // Check email addresses validity by using PHP's internal filter_var function
                    if( filter_var( $formDataArr[$email_sender_mapping]['value'], FILTER_VALIDATE_EMAIL ) )
                    {
                        $from = $formDataArr[$email_sender_mapping]['value'];
                    }
                }
            }
            else
            {
                // Check email addresses validity by using PHP's internal filter_var function
                if( filter_var( $handlerConfigArr['email_sender'], FILTER_VALIDATE_EMAIL ) )
                {
                    $from = $handlerConfigArr['email_sender'];
                }
            }
        }

        $to = false;
        if ( isset( $handlerConfigArr['email_receiver'] ) )
        {
            if( substr( $handlerConfigArr['email_receiver'], 0, 1 ) === '@' )
            {
                $email_receiver_mapping = substr( $handlerConfigArr['email_receiver'], 1 );
                if( isset( $formDataArr[$email_receiver_mapping]['value'] ) )
                {
                    // Check email addresses validity by using PHP's internal filter_var function
                    if ( filter_var( $formDataArr[$email_receiver_mapping]['value'], FILTER_VALIDATE_EMAIL ) )
                    {
                        $to = $formDataArr[$email_receiver_mapping]['value'];
                    }
                }
            }
            else
            {
                // Check email addresses validity by using PHP's internal filter_var function
                if ( filter_var( $handlerConfigArr['email_receiver'], FILTER_VALIDATE_EMAIL ) )
                {
                    $to = $handlerConfigArr['email_receiver'];
                }
            }
        }

        $logging = false;
        if ( isset( $handlerConfigArr['logging'] ) && $handlerConfigArr['logging'] === true )
        {
            $logging = true;
        }

        $debug = false;
        if ( isset( $handlerConfigArr['debug'] ) && $handlerConfigArr['debug'] === true )
        {
            $debug = true;
        }

        $bcc = array();
        if( isset($handlerConfigArr['email_bcc']))
        {
            $bcc = $handlerConfigArr['email_bcc'];
        }

        if ( $template !== false && $subject !== false && $from !== false && $to !== false )
        {
// ToDo: render template inline if $template false

            $templateContent = $this->container->get('twig')->loadTemplate($template);

            $templateParameters =
                array( 'form' => $form->createView(),
                       'form_data_array' => $formDataArr,
                       'form_data_object' => $formDataObj,
                       'content' => $content,
                       'location' => $location );

            $bodyTextHtml = $templateContent->renderBlock('body_text_html',
                    $templateParameters
            );

            $bodyTextPlain = $templateContent->renderBlock('body_text_plain',
                $templateParameters
            );

            $message = \Swift_Message::newInstance()
//                ->setEncoder(\Swift_Encoding::get7BitEncoding())
//                ->setCharset('UTF-8')
                ->setEncoder( \Swift_Encoding::get8BitEncoding() )
                ->setSubject( $subject )
                ->setFrom( $from )
                ->setTo( $to )
                ->setBcc( $bcc )
                ->setBody( $bodyTextHtml, 'text/html' )
                ->addPart( $bodyTextPlain, 'text/plain' );

            if ( $debug === false )
            {
               $this->mailer->send( $message );
            }

            if ( $logging === true )
            {
                $msgId = substr( $message->getHeaders()->get( 'Message-ID' )->getFieldBody(), 1, -1 );

                //$dump = $message->toString(); <- this is the "real" output sent by the mailer
                $dump = $msgId."\n\n".$bodyTextPlain.$bodyTextHtml; // <- this is the "clean" uncoded output fetched directly from the template

//                $dump = str_replace( 'search', '', $message->toString() );

                $log_dir = $this->container->getParameter( 'kernel.logs_dir' ) . '/formbuilder/';

                if ( is_dir( $log_dir ) === false )
                {
                    mkdir( $log_dir );
                }

                file_put_contents( $log_dir.time() . '_' . $msgId, $dump );
            }
        }
        else
        {
            if( $debug == true )
            {
                $error =
                    'Error: All parameters ($template, $subject, $from, $to) must be provided <br> <br>
                     This error was thrown on line: <font color="#5f9ea0">'.__LINE__.'</font><br>'.
                    'Of file: <font color="#5f9ea0">'.__FILE__. '</font><br>'.
                    'Inside of function: <font color="#5f9ea0">'.__FUNCTION__.'</font> <br>'.
                    '<br> <font color="red">Warning: </font> if this error is shown in production, disable debug!';

                die( $error );
            }
            else
            {
                die( "search for: error code #244" );
            }
        }

        return false;
    }

    /**
     * Handle a success action
     *
     * @param mixed $formDataObj
     * @param array $handlerConfigArr
     * @param mixed $handlerParameters
     *
     * @return result
     */
    public function successHandler( $formDataObj, $handlerConfigArr, $handlerParameters, $form )
    {
        $content = false;
        if ( isset( $handlerParameters['content'] ) )
        {
            $content = $handlerParameters['content'];
        }

        $location = false;
        if ( isset( $handlerParameters['location'] ) )
        {
            $location = $handlerParameters['location'];
        }

        $template = $this->formBuilderService->getTemplateOverride( $handlerConfigArr['template'] );


        $formDataArr = $this->getFormDataArray( $formDataObj );

        // ToDo: template checks, if false render inline

        return $this->templating->render(
            $template,
            array( 'form' => $form->createView(),
                   'form_data_array' => $formDataArr,
                   'form_data_object' => $formDataObj,
                   'content' => $content,
                   'location' => $location )
        );
    }

    /**
     * ToDo
     */
    public function contentAddHandler()
    {
        return false;
    }

    /**
     * ToDo
     */
    public function contentEditHandler()
    {
        return false;
    }

    protected function getFormDataArray( $formDataObj )
    {
        $formDataArr = array();
        foreach ( $formDataObj as $formIdentifier => $formValue )
        {
            // ezstring:first_name  => ezstring__first_name
            $keyArr = explode( FormHandlerService::separator, $formIdentifier );
            // ezstring
            $contentType = $keyArr['0'];
            // first_name
            $fieldIdentifier = $keyArr['1'];

            $formDataArr[$fieldIdentifier] = array( 'value' => $formValue,
                'content_type'  => $contentType,
                'field_identifier' => $fieldIdentifier,
                'form_identifier' => $formIdentifier
            );
        }

        return $formDataArr;
    }
}
