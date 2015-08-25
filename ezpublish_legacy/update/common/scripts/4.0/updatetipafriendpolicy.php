#!/usr/bin/env php
<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

require 'autoload.php';

$cli = eZCLI::instance();

$script = eZScript::instance( array( 'description' => "\nThis script is optional for upgrading to 3.10.\n" .
                                                       "The script adds a role which contains a policy 'content/tipafriend' and" .
                                                       "\nassigns this role to all user groups except anonymous. That will give " .
                                                       "\npossibility to use tipafriend view for all users except anonymous." .
                                                       "\n\nNote: siteacces, login and password options are required and" .
                                                       "\nmust to be set to admin siteaccess and admin login/passsword accordingly" .
                                                       "\n\n(See doc/feature/(3.8|3.9|3.10)/content_tipafriend_policy.txt for more information).",
                                      'use-session' => false,
                                      'use-modules' => false,
                                      'use-extensions' => true ) );

$script->startup();
$options = $script->getOptions( '', '', false, false,
                                array( 'siteaccess' => true,
                                       'user' => true ) );

$siteAccess = $options['siteaccess'] ? $options['siteaccess'] : false;
$script->setUseSiteAccess( $siteAccess );
$script->initialize();

$cli->output( "\nStart." );

$contentIni = eZINI::instance( 'content.ini' );
$userRootNodeID = $contentIni->variable( 'NodeSettings', 'UserRootNode' );

$siteIni = eZINI::instance( 'site.ini' );
$anonymousUserID = $siteIni->variable( 'UserSettings', 'AnonymousUserID' );
$anonymousUser = eZUser::fetch( $anonymousUserID );
$anonymousUsers = array();
if ( is_object( $anonymousUser ) )
{
    $anonymousUsers = $anonymousUser->groups();
    $anonymousUsers[] = $anonymousUserID;
}

$topUserNodes = eZContentObjectTreeNode::subTreeByNodeID( array( 'Depth' => 1 ), $userRootNodeID );

if ( count( $topUserNodes ) == 0 )
{
    $cli->warning( "Unable to retrieve the user root node. Please make sure\n" .
                   "you log in to the system with the administrator's user\n" .
                   "acount by using the -l and -p command line options." );
    $script->shutdown( 1 );
}

$roleName = 'Tipafriend Role';
$role = eZRole::fetchByName( $roleName );
if ( is_object( $role ) )
{
    $cli->warning( "The 'Tipafriend Role' already exists in the system. This means that\n" .
                   "the script was already run before or the same role was added manually.\n" .
                   "The role will not be added. Check the role settings of the system." );
}
else
{
    $userInput = '';
    $usersToAssign = array();
    $stdin = fopen( "php://stdin", "r+" );
    foreach ( $topUserNodes as $userNode )
    {
        if ( $userInput != 'a' )
        {
            $name = $userNode->getName();
            if ( in_array( $userNode->attribute( 'contentobject_id' ), $anonymousUsers ) )
                $cli->output( "Note: the '$name' group/user is anonymous." );
            $cli->output( "Assign 'Tipafriend Role' to the '$name' group/user? y(yes)/n(no)/a(all)/s(skip all): ", false );
            $userInput = fgets( $stdin );
            $userInput = trim( $userInput );
        }
        if ( $userInput == 'y' or $userInput == 'a' )
        {
            $usersToAssign[] = $userNode->attribute( 'contentobject_id' );
        }
        else if ( $userInput == 's' )
        {
            break;
        }
    }
    fclose( $stdin );

    if ( count( $usersToAssign ) > 0 )
    {
        $role = eZRole::create( $roleName );
        $role->store();
        $role->appendPolicy( 'content', 'tipafriend' );
        $role->store();

        foreach ( $usersToAssign as $userID )
        {
            $role->assignToUser( $userID );
        }
        // clear role cache
        eZRole::expireCache();
        eZContentCacheManager::clearAllContentCache();
        // clear policy cache
        eZUser::cleanupCache();
    }
    else
    {
        $cli->notice( "\nThe role wasn't added because you didn't choose any group to assign." );
    }
}

$cli->output( "\nDone." );
$script->shutdown();

?>
