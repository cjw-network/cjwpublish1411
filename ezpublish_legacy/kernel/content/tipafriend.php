<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$http = eZHTTPTool::instance();

$NodeID = (int)$Params['NodeID'];
$Module = $Params['Module'];

$tpl = eZTemplate::factory();
$tpl->setVariable( 'action', '' );

$error_strings = array();
$yourName = '';
$yourEmail = '';
$user = eZUser::currentUser();
$ini = eZINI::instance();
// Get name and email from current user, unless it is the anonymous user
if ( is_object( $user ) && $user->id() != $ini->variable( 'UserSettings', 'AnonymousUserID' ) )
{
    $userObject = $user->attribute( 'contentobject' );
    $yourName = $userObject->attribute( 'name' );
    $yourEmail = $user->attribute( 'email' );
}
$receiversName = '';
$receiversEmail = '';

if ( $http->hasPostVariable( 'NodeID' ) )
    $NodeID = (int)$http->variable( 'NodeID' );

$node = eZContentObjectTreeNode::fetch( $NodeID );
if ( is_object( $node ) )
{
    $nodeName = $node->getName();
}
else
{
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

$object = $node->object();
if ( !$object->canRead() )
{
    return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel', array( 'AccessList' => $object->accessList( 'read' ) ) );
}

$hostName = eZSys::hostname();
$subject = ezpI18n::tr( 'kernel/content', 'Tip from %1: %2', null, array( $hostName, $nodeName ) );
$comment = '';
$overrideKeysAreSet = false;

if ( $http->hasPostVariable( 'SendButton' ) )
{
    if ( $http->hasPostVariable( 'YourName' ) )
        $yourName = $http->variable( 'YourName' );

    if ( $http->hasPostVariable( 'YourEmail' ) )
        $yourEmail = $http->variable( 'YourEmail' );

    if ( $http->hasPostVariable( 'ReceiversEmail' ) )
        $receiversEmail = $http->variable( 'ReceiversEmail' );

    $receiversName = $receiversEmail;
    if ( $http->hasPostVariable( 'ReceiversName' ) )
        $receiversName = $http->variable( 'ReceiversName' );

    if ( $http->hasPostVariable( 'Subject' ) )
        $subject = $http->variable( 'Subject' );

    if ( $http->hasPostVariable( 'Comment' ) )
        $comment = $http->variable( 'Comment' );

    // email validation
    if ( !eZMail::validate( $yourEmail ) )
        $error_strings[] = ezpI18n::tr( 'kernel/content', 'The email address of the sender is not valid' );
    if ( !eZMail::validate( $receiversEmail ) )
        $error_strings[] = ezpI18n::tr( 'kernel/content', 'The email address of the receiver is not valid' );

    $fromEmail = null;

    if ( $ini->hasVariable( 'TipAFriend', 'FromEmail' ) )
    {
        $fromEmail = $ini->variable( 'TipAFriend', 'FromEmail' );
        if ( $fromEmail != null )
            if ( !eZMail::validate( $fromEmail ) )
            {
                eZDebug::writeError( "The email < $fromEmail > specified in [TipAFriend].FromEmail setting in site.ini is not valid",'tipafriend' );
                $fromEmail = null;
            }
    }
    if ( $fromEmail == null )
        $fromEmail = $yourEmail;

    if ( $http->hasSessionVariable('ezpContentTipafriendList') )
    {
        if ( strpos( $http->sessionVariable('ezpContentTipafriendList'), $NodeID . '|' . $receiversEmail ) !== false )
            $error_strings[] = ezpI18n::tr( 'kernel/content', "You have already sent a tipafriend mail to this receiver regarding '%1' content", null, array( $nodeName ) );
    }

    if ( !isset( $error_strings[0] ) && !eZTipafriendRequest::checkReceiver( $receiversEmail ) )
        $error_strings[] = ezpI18n::tr( 'kernel/content', 'The receiver has already received the maximum number of tipafriend mails the last hours' );

    // no validation errors
    if ( count( $error_strings ) == 0 )
    {
        $mail = new eZMail();
        $mail->setSender( $fromEmail, $yourName );
        $mail->setReceiver( $receiversEmail, $receiversName );
        $mail->setSubject( $subject );

        // fetch
        $sectionID = $object->attribute( 'section_id' );
        $section = eZSection::fetch( $sectionID );
        $res = eZTemplateDesignResource::instance();
        $res->setKeys( array( array( 'object',           $object->attribute( 'id' ) ),
                              array( 'remote_id',        $object->attribute( 'remote_id' ) ),
                              array( 'node_remote_id',   $node->attribute( 'remote_id' ) ),
                              array( 'class',            $object->attribute( 'contentclass_id' ) ),
                              array( 'class_identifier', $object->attribute( 'class_identifier' ) ),
                              array( 'class_group',      $object->attribute( 'match_ingroup_id_list' ) ),
                              array( 'section',          $object->attribute( 'section_id' ) ),
                              array( 'section_identifier', $section->attribute( 'identifier' ) ),
                              array( 'node',             $NodeID ),
                              array( 'parent_node',      $node->attribute( 'parent_node_id' ) ),
                              array( 'depth',            $node->attribute( 'depth' ) ),
                              array( 'url_alias',        $node->attribute( 'url_alias' ) )
                              ) );
        $overrideKeysAreSet = true;

        // fetch text from mail template
        $mailtpl = eZTemplate::factory();
        $mailtpl->setVariable( 'hostname', $hostName );
        $mailtpl->setVariable( 'nodename', $nodeName );
        $mailtpl->setVariable( 'node_id', $NodeID );
        $mailtpl->setVariable( 'node', $node );
        $mailtpl->setVariable( 'your_name', $yourName );
        $mailtpl->setVariable( 'your_email', $yourEmail );
        $mailtpl->setVariable( 'receivers_name', $receiversName );
        $mailtpl->setVariable( 'receivers_email', $receiversEmail );
        $mailtpl->setVariable( 'comment', $comment );
        $mailtext = $mailtpl->fetch( 'design:content/tipafriendmail.tpl' );

        if ( $mailtpl->hasVariable( 'content_type' ) )
            $mail->setContentType( $mailtpl->variable( 'content_type' ) );

        $mail->setBody( $mailtext );

        // mail was sent ok
        if ( eZMailTransport::send( $mail ) )
        {
            $tpl->setVariable( 'action', 'confirm' );

            $request = eZTipafriendRequest::create( $receiversEmail );
            $request->store();

            // Increase tipafriend count for this node
            $counter = eZTipafriendCounter::create( $NodeID );
            $counter->store();

            // Prevent user from sending tipafriend mail to same user on same node again for the rest of session
            $sessionSentTipList = $NodeID . '|' . $receiversEmail;
            if ( $http->hasSessionVariable('ezpContentTipafriendList') )
            {
                $sessionSentTipList = $http->sessionVariable('ezpContentTipafriendList') . ',' . $sessionSentTipList;
            }
            $http->setSessionVariable('ezpContentTipafriendList', $sessionSentTipList );
        }
        else // some error occured
        {
            $tpl->setVariable( 'action', 'error' );
        }
        if ( $http->hasPostVariable( 'RedirectBack' ) && $http->postVariable( 'RedirectBack' ) == 1 )
        {
            $Module->redirectTo( $node->attribute( 'url_alias' ) );
            return;
        }
    }
}
else if ( $http->hasPostVariable( 'CancelButton' ) )
{
    $Module->redirectTo( $node->attribute( 'url_alias' ) );
}

if ( !$overrideKeysAreSet )
{
    $sectionID = $object->attribute( 'section_id' );
    $section = eZSection::fetch( $sectionID );
    $res = eZTemplateDesignResource::instance();
    $res->setKeys( array( array( 'object',           $object->attribute( 'id' ) ),
                          array( 'remote_id',        $object->attribute( 'remote_id' ) ),
                          array( 'node_remote_id',   $node->attribute( 'remote_id' ) ),
                          array( 'class',            $object->attribute( 'contentclass_id' ) ),
                          array( 'class_identifier', $object->attribute( 'class_identifier' ) ),
                          array( 'class_group',      $object->attribute( 'match_ingroup_id_list' ) ),
                          array( 'section',          $object->attribute( 'section_id' ) ),
                          array( 'section_identifier', $section->attribute( 'identifier' ) ),
                          array( 'node',             $NodeID ),
                          array( 'parent_node',      $node->attribute( 'parent_node_id' ) ),
                          array( 'depth',            $node->attribute( 'depth' ) ),
                          array( 'url_alias',        $node->attribute( 'url_alias' ) )
                          ) );
}

$Module->setTitle( 'Tip a friend' );

$tpl->setVariable( 'node_id', $NodeID );
$tpl->setVariable( 'node', $node );
$tpl->setVariable( 'error_strings', $error_strings );
$tpl->setVariable( 'your_name', $yourName );
$tpl->setVariable( 'your_email', $yourEmail );
$tpl->setVariable( 'receivers_name', $receiversName );
$tpl->setVariable( 'receivers_email', $receiversEmail );
$tpl->setVariable( 'subject', $subject );
$tpl->setVariable( 'comment', $comment );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:content/tipafriend.tpl' );
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/content', 'Tip a friend' ),
                                'url' => false ) );

?>
