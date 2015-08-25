<?php
/**
 * File containing the eZFinishUserRegisterType class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZFinishUserRegisterType ezfinishuserregistertype.php
  \brief Event type for finishing register type
*/

class eZFinishUserRegisterType extends eZWorkflowEventType {

    const WORKFLOW_TYPE_STRING = "ezfinishuserregister";

    public function  __construct()
    {
        $this->eZWorkflowEventType( eZFinishUserRegisterType::WORKFLOW_TYPE_STRING, ezpI18n::tr( 'kernel/workflow/event', "Finish User Registration" ) );
        $this->setTriggerTypes( array( 'content' => array( 'publish' => array( 'after' ) ) ) );
    }

    function execute($process, $event)
    {
        //execute user register operation
        $parameterList = $process->attribute( 'parameter_list' );
        $objectID = $parameterList['object_id'];
        $object = eZContentObject::fetch( $objectID );
        // @todo: improve the possible performance.
        if( $object->attribute( 'class_identifier' ) == 'user' )
        {
            $result = eZOperationHandler::execute( 'user', 'register', array( 'user_id' => $objectID ) );
            return $result['status'];
        }
    }

    function typeFunctionalAttributes( )
    {
        return array( 'selected_sections',
                      'approve_users',
                      'approve_groups',
                      'selected_usergroups',
                      'language_list',
                      'version_option' );
    }

    function attributeDecoder( $event, $attr )
    {

    }

    function attributes()
    {
        return array_merge( array( 'sections',
                                   'languages',
                                   'users',
                                   'usergroups' ),
                            eZWorkflowEventType::attributes() );

    }

}

eZWorkflowEventType::registerEventType( eZFinishUserRegisterType::WORKFLOW_TYPE_STRING, "eZFinishUserRegisterType" );
?>
