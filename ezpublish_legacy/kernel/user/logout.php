<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$http = eZHTTPTool::instance();

$user = eZUser::instance();

// Remove all temporary drafts
eZContentObject::cleanupAllInternalDrafts( $user->attribute( 'contentobject_id' ) );

$user->logoutCurrent();

$http->setSessionVariable( 'force_logout', 1 );

$ini = eZINI::instance();
if ( $ini->variable( 'UserSettings', 'RedirectOnLogoutWithLastAccessURI' ) == 'enabled' && $http->hasSessionVariable( 'LastAccessesURI' ))
{
    $redirectURL = $http->sessionVariable( "LastAccessesURI" );
}
else
{
    $redirectURL = $http->postVariable( 'RedirectURI', $ini->variable( 'UserSettings', 'LogoutRedirect' ) );
}

return $Module->redirectTo( $redirectURL );

?>
