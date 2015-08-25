<?php
/**
 * File containing the eZSubTreeHandler class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZSubTreeHandler ezsubtreehandler.php
  \brief The class eZSubTreeHandler does

*/

class eZSubTreeHandler extends eZNotificationEventHandler
{
    const NOTIFICATION_HANDLER_ID = 'ezsubtree';
    const TRANSPORT = 'ezmail';

    /*!
     Constructor
    */
    function eZSubTreeHandler()
    {
        $this->eZNotificationEventHandler( self::NOTIFICATION_HANDLER_ID, "Subtree Handler" );
    }

    function attributes()
    {
        return array_merge( array( 'subscribed_nodes',
                                   'rules' ),
                            eZNotificationEventHandler::attributes() );
    }

    function hasAttribute( $attr )
    {
        return in_array( $attr, $this->attributes() );
    }

    function attribute( $attr )
    {
        if ( $attr == 'subscribed_nodes' )
        {
            $user = eZUser::currentUser();
            return $this->subscribedNodes( $user );
        }
        else if ( $attr == 'rules' )
        {
            $user = eZUser::currentUser();
            return $this->rules( $user );
        }
        return eZNotificationEventHandler::attribute( $attr );
    }

    function handle( $event )
    {
        eZDebugSetting::writeDebug( 'kernel-notification', $event, "trying to handle event" );
        if ( $event->attribute( 'event_type_string' ) == 'ezpublish' )
        {
            $parameters = array();
            $status = $this->handlePublishEvent( $event, $parameters );
            if ( $status == eZNotificationEventHandler::EVENT_HANDLED )
                $this->sendMessage( $event, $parameters );
            else
                return false;
        }
        return true;
    }

    function handlePublishEvent( $event, &$parameters )
    {
        $versionObject = $event->attribute( 'content' );
        if ( !$versionObject )
            return eZNotificationEventHandler::EVENT_SKIPPED;
        $contentObject = $versionObject->attribute( 'contentobject' );
        if ( !$contentObject )
            return eZNotificationEventHandler::EVENT_SKIPPED;
        $contentNode = $contentObject->attribute( 'main_node' );
        if ( !$contentNode )
            return eZNotificationEventHandler::EVENT_SKIPPED;

        // Notification should only be sent out when the object is published (is visible)
        if ( $contentNode->attribute( 'is_invisible' ) == 1 )
           return eZNotificationEventHandler::EVENT_SKIPPED;
        $contentClass = $contentObject->attribute( 'content_class' );
        if ( !$contentClass )
            return eZNotificationEventHandler::EVENT_SKIPPED;
        if ( // $versionObject->attribute( 'version' ) != 1 ||
             $versionObject->attribute( 'version' ) != $contentObject->attribute( 'current_version' ) )
        {
            return eZNotificationEventHandler::EVENT_SKIPPED;
        }
        $tpl = eZTemplate::factory();
        $tpl->resetVariables();

        $parentNode = $contentNode->attribute( 'parent' );
        if ( !$parentNode instanceof eZContentObjectTreeNode )
        {
            eZDebug::writeError( 'DB corruption: Node id ' . $contentNode->attribute( 'node_id' ) . ' is missing parent node.', __METHOD__ );
            return eZNotificationEventHandler::EVENT_SKIPPED;
        }

        $parentContentObject = $parentNode->attribute( 'object' );
        if ( !$parentContentObject instanceof eZContentObject )
        {
            eZDebug::writeError( 'DB corruption: Node id ' . $parentNode->attribute( 'node_id' ) . ' is missing object.', __METHOD__ );
            return eZNotificationEventHandler::EVENT_SKIPPED;
        }

        $parentContentClass = $parentContentObject->attribute( 'content_class' );
        if ( !$parentContentClass instanceof eZContentClass )
        {
            eZDebug::writeError( 'DB corruption: Object id ' . $parentContentObject->attribute( 'id' ) . ' is missing class object.', __METHOD__ );
            return eZNotificationEventHandler::EVENT_SKIPPED;
        }

        $res = eZTemplateDesignResource::instance();
        $res->setKeys( array( array( 'object', $contentObject->attribute( 'id' ) ),
                              array( 'node', $contentNode->attribute( 'node_id' ) ),
                              array( 'class', $contentObject->attribute( 'contentclass_id' ) ),
                              array( 'class_identifier', $contentClass->attribute( 'identifier' ) ),
                              array( 'parent_node', $contentNode->attribute( 'parent_node_id' ) ),
                              array( 'parent_class', $parentContentObject->attribute( 'contentclass_id' ) ),
                              array( 'parent_class_identifier', ( $parentContentClass != null ? $parentContentClass->attribute( 'identifier' ) : 0 ) ),
                              array( 'depth', $contentNode->attribute( 'depth' ) ),
                              array( 'url_alias', $contentNode->attribute( 'url_alias' ) )
                              ) );

        $tpl->setVariable( 'object', $contentObject );

        $notificationINI = eZINI::instance( 'notification.ini' );
        $emailSender = $notificationINI->variable( 'MailSettings', 'EmailSender' );
        $ini = eZINI::instance();
        if ( !$emailSender )
            $emailSender = $ini->variable( 'MailSettings', 'EmailSender' );
        if ( !$emailSender )
            $emailSender = $ini->variable( "MailSettings", "AdminEmail" );
        $tpl->setVariable( 'sender', $emailSender );

        $result = $tpl->fetch( 'design:notification/handler/ezsubtree/view/plain.tpl' );
        $subject = $tpl->variable( 'subject' );
        if ( $tpl->hasVariable( 'message_id' ) )
            $parameters['message_id'] = $tpl->variable( 'message_id' );
        if ( $tpl->hasVariable( 'references' ) )
            $parameters['references'] = $tpl->variable( 'references' );
        if ( $tpl->hasVariable( 'reply_to' ) )
            $parameters['reply_to'] = $tpl->variable( 'reply_to' );
        if ( $tpl->hasVariable( 'from' ) )
            $parameters['from'] = $tpl->variable( 'from' );
        if ( $tpl->hasVariable( 'content_type' ) )
            $parameters['content_type'] = $tpl->variable( 'content_type' );

        $collection = eZNotificationCollection::create( $event->attribute( 'id' ),
                                                        self::NOTIFICATION_HANDLER_ID,
                                                        self::TRANSPORT );

        $collection->setAttribute( 'data_subject', $subject );
        $collection->setAttribute( 'data_text', $result );
        $collection->store();

        $assignedNodes = $contentObject->parentNodes( true );
        $nodeIDList = array();
        foreach( $assignedNodes as $node )
        {
            if ( $node )
            {
                $pathString = $node->attribute( 'path_string' );
                $pathString = ltrim( rtrim( $pathString, '/' ), '/' );
                $nodeIDListPart = explode( '/', $pathString );
                $nodeIDList = array_merge( $nodeIDList, $nodeIDListPart );
            }
        }
        $nodeIDList[] = $contentNode->attribute( 'node_id' );
        $nodeIDList = array_unique( $nodeIDList );

        $userList = eZSubtreeNotificationRule::fetchUserList( $nodeIDList, $contentObject );

        $locale = eZLocale::instance();
        $weekDayNames = $locale->attribute( 'weekday_name_list' );
        $weekDaysByName = array_flip( $weekDayNames );

        foreach( $userList as $subscriber )
        {
            $item = $collection->addItem( $subscriber['address'] );
            if ( $subscriber['use_digest'] == 0 )
            {
                $settings = eZGeneralDigestUserSettings::fetchByUserId( $subscriber['user_id'] );
                if ( $settings !== null && $settings->attribute( 'receive_digest' ) == 1 )
                {
                    $time = $settings->attribute( 'time' );
                    $timeArray = explode( ':', $time );
                    $hour = $timeArray[0];

                    if ( $settings->attribute( 'digest_type' ) == eZGeneralDigestUserSettings::TYPE_DAILY )
                    {
                        eZNotificationSchedule::setDateForItem( $item, array( 'frequency' => 'day',
                                                                              'hour' => $hour ) );
                    }
                    else if ( $settings->attribute( 'digest_type' ) == eZGeneralDigestUserSettings::TYPE_WEEKLY )
                    {
                        $weekday = $weekDaysByName[ $settings->attribute( 'day' ) ];
                        eZNotificationSchedule::setDateForItem( $item, array( 'frequency' => 'week',
                                                                              'day' => $weekday,
                                                                              'hour' => $hour ) );
                    }
                    else if ( $settings->attribute( 'digest_type' ) == eZGeneralDigestUserSettings::TYPE_MONTHLY )
                    {
                        eZNotificationSchedule::setDateForItem( $item,
                                                                array( 'frequency' => 'month',
                                                                       'day' => $settings->attribute( 'day' ),
                                                                       'hour' => $hour ) );
                    }
                    $item->store();
                }
            }
        }
        return eZNotificationEventHandler::EVENT_HANDLED;
    }

    function sendMessage( $event, $parameters )
    {
        $collection = eZNotificationCollection::fetchForHandler( self::NOTIFICATION_HANDLER_ID,
                                                                 $event->attribute( 'id' ),
                                                                 self::TRANSPORT );

        if ( !$collection )
            return;

        $items = $collection->attribute( 'items_to_send' );

        if ( !$items )
        {
            eZDebugSetting::writeDebug( 'kernel-notification', "No items to send now" );
            return;
        }
        $addressList = array();
        foreach ( $items as $item )
        {
            $addressList[] = $item->attribute( 'address' );
            $item->remove();
        }

        $transport = eZNotificationTransport::instance( 'ezmail' );
        $transport->send( $addressList, $collection->attribute( 'data_subject' ), $collection->attribute( 'data_text' ), null,
                          $parameters );
        if ( $collection->attribute( 'item_count' ) == 0 )
        {
            $collection->remove();
        }
    }

    function subscribedNodes( $user = false )
    {
        if ( $user === false )
        {
            $user = eZUser::currentUser();
        }
        $userID = $user->attribute( 'contentobject_id' );

        return eZSubtreeNotificationRule::fetchNodesForUserID( $userID );
    }

    static function rules( $user = false, $offset = false, $limit = false )
    {
        if ( $user === false )
        {
            $user = eZUser::currentUser();
        }
        $userID = $user->attribute( 'contentobject_id' );

        return eZSubtreeNotificationRule::fetchList( $userID, true, $offset, $limit );
    }

    static function rulesCount( $user = false )
    {
        if ( $user === false )
        {
            $user = eZUser::currentUser();
        }
        $userID = $user->attribute( 'contentobject_id' );

        return eZSubtreeNotificationRule::fetchListCount( $userID );
    }

    function fetchHttpInput( $http, $module )
    {
        if ( $http->hasPostVariable( 'NewRule_' . self::NOTIFICATION_HANDLER_ID  ) )
        {
            eZContentBrowse::browse( array( 'action_name' => 'AddSubtreeSubscribingNode',
                                            'from_page' => '/notification/settings/' ),
                                     $module );

        }
        else if ( $http->hasPostVariable( 'RemoveRule_' . self::NOTIFICATION_HANDLER_ID  ) and
                  $http->hasPostVariable( 'SelectedRuleIDArray_' . self::NOTIFICATION_HANDLER_ID ) )
        {
            $user = eZUser::currentUser();
            $userList = eZSubtreeNotificationRule::fetchList( $user->attribute( 'contentobject_id' ), false );
            foreach ( $userList as $userRow )
            {
                $listID[] = $userRow['id'];
            }
            $ruleIDList = $http->postVariable( 'SelectedRuleIDArray_' . self::NOTIFICATION_HANDLER_ID );
            foreach ( $ruleIDList as $ruleID )
            {
                if ( in_array( $ruleID, $listID ) )
                    eZPersistentObject::removeObject( eZSubtreeNotificationRule::definition(), array( 'id' => $ruleID ) );
            }
        }
        else if ( $http->hasPostVariable( "BrowseActionName" ) and
                  $http->postVariable( "BrowseActionName" ) == "AddSubtreeSubscribingNode" and
                  !$http->hasPostVariable( 'BrowseCancelButton' ) )
        {
            $selectedNodeIDArray = $http->postVariable( "SelectedNodeIDArray" );
            $user = eZUser::currentUser();

            $existingNodes = eZSubtreeNotificationRule::fetchNodesForUserID( $user->attribute( 'contentobject_id' ), false );

            foreach ( $selectedNodeIDArray as $nodeID )
            {
                if ( ! in_array( $nodeID, $existingNodes ) )
                {
                    $rule = eZSubtreeNotificationRule::create( $nodeID, $user->attribute( 'contentobject_id' ) );
                    $rule->store();
                }
            }
//            $Module->redirectTo( "//list/" );
        }

    }

    function cleanup()
    {
        eZSubtreeNotificationRule::cleanup();
    }
}

?>
