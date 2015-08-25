<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$http = eZHTTPTool::instance();
$SectionID = $Params["SectionID"];
$Module = $Params['Module'];

if ( $http->hasPostVariable( 'BrowseCancelButton' ) )
{
    if ( $http->hasPostVariable( 'BrowseCancelURI' ) )
    {
        return $Module->redirectTo( $http->postVariable( 'BrowseCancelURI' ) );
    }
}
else
{
    $section = eZSection::fetch( $SectionID );
    if ( !is_object( $section ) )
    {
        eZDebug::writeError( "Cannot fetch section (ID = $SectionID).", 'section/assign' );
    }
    else
    {
        $currentUser = eZUser::currentUser();

        if ( $currentUser->canAssignSection( $SectionID ) )
        {
            if ( $Module->isCurrentAction( 'AssignSection' ) )
            {   // Assign section to subtree of node

                $selectedNodeIDArray = eZContentBrowse::result( 'AssignSection' );
                if ( is_array( $selectedNodeIDArray ) and count( $selectedNodeIDArray ) > 0 )
                {
                    $nodeList = eZContentObjectTreeNode::fetch( $selectedNodeIDArray );
                    if ( !is_array( $nodeList ) and is_object( $nodeList ) )
                    {
                        $nodeList = array( $nodeList );
                    }

                    $allowedNodeIDList = array();
                    $deniedNodeIDList = array();
                    foreach ( $nodeList as $node )
                    {
                        $nodeID = $node->attribute( 'node_id' );
                        $object = $node->attribute( 'object' );
                        if ( $currentUser->canAssignSectionToObject( $SectionID, $object ) )
                        {
                            $allowedNodeIDList[] = $nodeID;
                        }
                        else
                        {
                            $deniedNodeIDList[] = $nodeID;
                        }
                    }

                    if ( count( $allowedNodeIDList ) > 0 )
                    {
                        $db = eZDB::instance();
                        $db->begin();
                        foreach ( $allowedNodeIDList as $nodeID )
                        {
                            eZContentObjectTreeNode::assignSectionToSubTree( $nodeID, $SectionID );
                        }
                        $db->commit();

                        // clear content caches
                        eZContentCacheManager::clearAllContentCache();
                    }
                    if ( count( $deniedNodeIDList ) > 0 )
                    {
                        $tpl = eZTemplate::factory();
                        $tpl->setVariable( 'section_name', $section->attribute( 'name' ) );
                        $tpl->setVariable( 'error_number', 1 );
                        $deniedNodes = eZContentObjectTreeNode::fetch( $deniedNodeIDList );
                        $tpl->setVariable( 'denied_node_list', $deniedNodes );

                        $Result = array();
                        $Result['content'] = $tpl->fetch( "design:section/assign_notification.tpl" );
                        $Result['path'] = array( array( 'url' => false,
                                                        'text' => ezpI18n::tr( 'kernel/section', 'Sections' ) ),
                                                 array( 'url' => false,
                                                        'text' => ezpI18n::tr( 'kernel/section', 'Assign section' ) ) );
                        return;
                    }
                }
            }
            else
            {
                // Redirect to content node browse
                $classList = $currentUser->canAssignSectionToClassList( $SectionID );
                if ( count( $classList ) > 0 )
                {
                    if ( in_array( '*', $classList ) )
                    {
                        $classList = false;
                    }
                    eZContentBrowse::browse( array( 'action_name' => 'AssignSection',
                                                    'keys' => array(),
                                                    'description_template' => 'design:section/browse_assign.tpl',
                                                    'content' => array( 'section_id' => $SectionID ),
                                                    'from_page' => '/section/assign/' . $SectionID . "/",
                                                    'cancel_page' => '/section/list',
                                                    'class_array' => $classList ),
                                             $Module );
                    return;
                }
                else
                {
                    $tpl = eZTemplate::factory();
                    $tpl->setVariable( 'section_name', $section->attribute( 'name' ) );
                    $tpl->setVariable( 'error_number', 2 );
                    $Result = array();
                    $Result['content'] = $tpl->fetch( "design:section/assign_notification.tpl" );
                    $Result['path'] = array( array( 'url' => false,
                                                    'text' => ezpI18n::tr( 'kernel/section', 'Sections' ) ),
                                             array( 'url' => false,
                                                    'text' => ezpI18n::tr( 'kernel/section', 'Assign section' ) ) );
                    return;
                }
            }
        }
        else
        {
            $tpl = eZTemplate::factory();
            $tpl->setVariable( 'section_name', $section->attribute( 'name' ) );
            $tpl->setVariable( 'error_number', 3 );
            $Result = array();
            $Result['content'] = $tpl->fetch( "design:section/assign_notification.tpl" );
            $Result['path'] = array( array( 'url' => false,
                                            'text' => ezpI18n::tr( 'kernel/section', 'Sections' ) ),
                                     array( 'url' => false,
                                            'text' => ezpI18n::tr( 'kernel/section', 'Assign section' ) ) );
            return;
        }
    }
}
$Module->redirectTo( '/section/list/' );

?>
