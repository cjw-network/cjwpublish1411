<?php
/**
 * Cronjob cjw_newsletter_create_mailqueue.php
 *
 * Send out all newsletter mails - which are in the mailqueue
 *
 * - search all cjwnl_edition_send_items, which are not send
 * - process every cjwnl_edition_send_item separatly
 * - generate the newsletter with personal user data (unsubsribe link, configure link, personalisation ... )
 * - send newsletter via mail + set status to SEND
 * - mutex support (no double execute of cronjobs)->integrate in runcronjobs.php
 *
 * @copyright Copyright (C) 2007-2012 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package cjw_newsletter
 * @subpackage cronjobs
 * @filesource
 */

// to fetch instance in Cli mode for separate logdata, cause access rights phpcli + webserver
$logInstance = CjwNewsletterLog::getInstance( true );

$message = "START: cjw_newsletter_mailqueue_process";
$cli->output( $message );

// to fetch all send objetc with status == STATUS_MALQUEUE_CREATED || STATUS_MALQUEUE_STARTED
$sendObjectList = CjwNewsletterEditionSend::fetchEditionSendListByStatus( array( CjwNewsletterEditionSend::STATUS_MAILQUEUE_CREATED , CjwNewsletterEditionSend::STATUS_MAILQUEUE_PROCESS_STARTED ) );

// - count all + how much should send?
// - if send = 0 at first element status == STATUS_MALQUEUE_STARTED
// - if send = count all => status == PROCESS_FINISHED
foreach ( $sendObjectList as $sendObject )
{
    // set startdate only at the first time
    if ( $sendObject->attribute( 'status' ) == CjwNewsletterEditionSend::STATUS_MAILQUEUE_CREATED )
    {
        // if ok, set status == STATUS_MAILQUEUE_PROCESS_STARTED
        $sendObject->setAttribute('status', CjwNewsletterEditionSend::STATUS_MAILQUEUE_PROCESS_STARTED );
        $sendObject->store();
        $message = "Status set: editonSend  STATUS_MAILQUEUE_PROCESS_STARTED";
        $cli->output( $message );
    }

    $output = new ezcConsoleOutput();
    $editionSendId = (int) $sendObject->attribute('id');
    $sendItemsStatistic = $sendObject->attribute('send_items_statistic');

    $itemsCountAll = $sendItemsStatistic['items_count'];
    $itemsSend = $sendItemsStatistic['items_send'];
    $itemsNotSend = $sendItemsStatistic['items_not_send'];

    // ### sendObject Data
    $outputFormatStringArray = $sendObject->getParsedOutputXml( );

    // embed images
    foreach( $outputFormatStringArray as $outputFormatId => $outputFormatNewsletterContentArray )
    {
       if( $outputFormatNewsletterContentArray['html_mail_image_include'] == 1 )
       {
           $outputFormatStringArray[ $outputFormatId ] = CjwNewsletterEdition::prepareImageInclude( $outputFormatNewsletterContentArray );
       }
    }
    // embed images ends

    $emailSender = $sendObject->attribute( 'email_sender' );
    $emailSenderName = $sendObject->attribute( 'email_sender_name' );
    $personalizeContent = (int) $sendObject->attribute( 'personalize_content' );

    $emailReplyTo = $sendObject->attribute( 'email_reply_to' );
    $emailReturnPath = $sendObject->attribute( 'email_return_path' );

    $limit = 50;
    $offset = 0;

    $itemCounter = 1;
    $progressMonitor = new ezcConsoleProgressMonitor( $output, $itemsNotSend );

    $cjwMail = new CjwNewsletterMail();
    $cjwMail->setTransportMethodCronjobFromIni();

    // process every send_item of current sendobject
    for( $i = 0; $i < $itemsNotSend; $i += $limit)
    {
      //  $progressBar->advance();
        $sendItemList = CjwNewsletterEditionSendItem::fetchListSendIdAndStatus( $editionSendId, CjwNewsletterEditionSendItem::STATUS_NEW, $limit, $offset );
        $count = count( $sendItemList );

        foreach ( $sendItemList as $sendItem )
        {
            $id = $sendItem->attribute('id');
            $outputFormatId = $sendItem->attribute('output_format_id');

            // ### subscription data
            $newsletterSubscriptionObject = $sendItem->attribute('newsletter_subscription_object');

            if ( is_object( $newsletterSubscriptionObject ) )
            {
                $newsletterUnsubscribeHash = $newsletterSubscriptionObject->attribute('hash');

                // ### get newsletter user data through send_item_object
                $newsletterUserObject = $sendItem->attribute( 'newsletter_user_object' );

                if ( is_object( $newsletterUserObject ) )
                {
                    $emailReceiver = $newsletterUserObject->attribute( 'email' );
                    $emailReceiverName = $newsletterUserObject->attribute( 'email_name' );

                    // ### configure hash
                    $newsletterConfigureHash = $newsletterUserObject->attribute( 'hash' );

                    // fetch html & text content of parsed outputxml from senmdobject
                    // data of outputformate
                    $outputStringArray = $outputFormatStringArray[$outputFormatId]['body'];
                    $emailSubject = $outputFormatStringArray[$outputFormatId]['subject'];

                    // parsed text and replace vars
                    // TODO parse extra variables

                    // START, add more hash keys
                    $searchArray = array(
                        '#_hash_unsubscribe_#',
                        '#_hash_configure_#',
                        '#_hash_item_#',
                        '#_hash_edition_#'
                    );

                    $replaceArray = array(
                        $newsletterUnsubscribeHash,
                        $newsletterConfigureHash,
                        $sendItem->attribute( 'hash' ),
                        $sendObject->attribute( 'hash' )
                    );
                    // END

                    if ( $personalizeContent === 1 )
                    {
                        $searchArray = array_merge( $searchArray,
                            array(
                                '[[name]]',
                                '[[salutation_name]]',
                                '[[first_name]]',
                                '[[last_name]]'
                            ) );
                        $replaceArray = array_merge( $replaceArray,
                            array(
                                $newsletterUserObject->attribute( 'name' ),
                                $newsletterUserObject->attribute( 'salutation_name' ),
                                $newsletterUserObject->attribute( 'first_name' ),
                                $newsletterUserObject->attribute( 'last_name' )
                            ) );
                    }

                    $outputStringArrayNew = array( 'html' => '', 'text' => '' );
                    foreach ( $outputStringArray as $index => $string )
                    {
                        $outputStringArrayNew[$index] = str_replace( $searchArray,
                            $replaceArray,
                            $string );
                    }

                    // START, replace in subject
                    $emailSubject = str_replace( $searchArray, $replaceArray, $emailSubject );
                    // END

                    // set x-cjwnl header
                    $cjwMail->resetExtraMailHeaders();
                    $cjwMail->setExtraMailHeadersByNewsletterSendItem( $sendItem );

                    $resultArray = $cjwMail->sendEmail( $emailSender,
                        $emailSenderName,
                        $emailReceiver,
                        $emailReceiverName,
                        $emailSubject,
                        $outputStringArrayNew,
                        false,
                        'utf-8',
                        $emailReplyTo,
                        $emailReturnPath );

                    $sendResult = $resultArray['send_result'];

                    if ( $sendResult === true )
                    {
                        // emal was send
                        $progressMonitor->addEntry( "[SEND] $itemCounter/$itemsNotSend",
                            "Newsletter send item {$id} processed. " );

                        // wenn ok als versendet markieren
                        $sendItem->setAttribute( 'status',
                            CjwNewsletterEditionSendItem::STATUS_SEND );
                        $sendItem->store();
                    }
                    else
                    {
                        // error execption
                        $exception = $resultArray['send_result'];
                        $progressMonitor->addEntry( "[FAILED] $itemCounter/$itemsNotSend",
                            "Newsletter send item {$id} failed, abort and bounce newsletter user." );
                        // abort item if mail returns directly e.g. mailbox not found
                        $sendItem->setAttribute( 'status',
                            CjwNewsletterEditionSendItem::STATUS_ABORT );
                        $sendItem->store();

                        // bounce send Item
                        $sendItem->setBounced();

                        // bounc nl user
                        $newsletterUser = $sendItem->attribute( 'newsletter_user_object' );
                        if ( is_object( $newsletterUser ) )
                        {
                            $isHardBounce = false;
                            // bounce nl user
                            $newsletterUser->setBounced( $isHardBounce );
                        }

                    }
                }

                // newsletter user object not available anymore => abort
                else
                {
                    // if object is not available anymore because of removal got to next item
                    $progressMonitor->addEntry( "[FAILED] $itemCounter/$itemsNotSend", "Newsletter send item {$id} failed - newsletter_user_object not available aborting. " );
                    // abort item if mail returns directly e.g. mailbox not found
                    $sendItem->setAttribute( 'status', CjwNewsletterEditionSendItem::STATUS_ABORT );
                    $sendItem->store();
                }

            }
            else
            {
                // if object is not available anymore because of removal got to next item
                $progressMonitor->addEntry( "[FAILED] $itemCounter/$itemsNotSend", "Newsletter send item {$id} failed - newsletter_subscription_object not available. " );
                // abort item if mail returns directly e.g. mailbox not found
                $sendItem->setAttribute( 'status', CjwNewsletterEditionSendItem::STATUS_ABORT );
                $sendItem->store();
            }

            // parse output_xml with user_content, normal or personalizied?
            // create email
            // send email

            $itemCounter++;

            // wait for 2/10 seconds
            // no, we do not sleep - we do work
            // usleep( 200000 );
        }
    }

    // all send_items of sendobject are send? if yes set status == PROCESS_FINISHED
    $sendObject->sync();
    $sendItemsStatistic = $sendObject->attribute('send_items_statistic');

    $itemsCountAll = $sendItemsStatistic['items_count'];
    $itemsSend = $sendItemsStatistic['items_send'];
    $itemsNotSend = $sendItemsStatistic['items_not_send'];
    $itemsAbort = $sendItemsStatistic['items_abort'];

    // if all objects send or abort than finish processing an archive
    if ( $itemsCountAll == ( $itemsSend + $itemsAbort ) )
    {
        // if ok, set status == STATUS_MAILQUEUE_PROCESS_FINISHED
        $sendObject->setAttribute('status', CjwNewsletterEditionSend::STATUS_MAILQUEUE_PROCESS_FINISHED  );
        $sendObject->store();

        $message = "Status set: editonSend  STATUS_MAILQUEUE_PROCESS_FINISHED";
        $cli->output( $message );
    }

    // var_dump( $sendItemsStatistic );
    $output->outputLine();
}

$message = "END: cjw_newsletter_mailqueue_process";
$cli->output( $message );

?>
