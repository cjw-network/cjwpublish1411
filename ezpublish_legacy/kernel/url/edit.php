<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */
$Module = $Params['Module'];
$urlID = null;
if ( isset( $Params["ID"] ) )
    $urlID = $Params["ID"];

if ( is_numeric( $urlID ) )
{
    $url = eZURL::fetch( $urlID );
    if ( !$url )
    {
        return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
    }
}
else
{
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

$http = eZHTTPTool::instance();
if ( $Module->isCurrentAction( 'Cancel' ) )
{
    $Module->redirectToView( 'list' );
    return;
}

if ( $Module->isCurrentAction( 'Store' ) )
{
    if ( $http->hasPostVariable( 'link' ) )
    {
        $link = $http->postVariable( 'link' );
        $url->setAttribute( 'url', $link );
        $url->store();
        eZURLObjectLink::clearCacheForObjectLink( $urlID );
    }
    $Module->redirectToView( 'list' );
    return;
}

$Module->setTitle( "Edit link " . $url->attribute( "id" ) );

// Template handling

$tpl = eZTemplate::factory();

$tpl->setVariable( "Module", $Module );
$tpl->setVariable( "url", $url );

$Result = array();
$Result['content'] = $tpl->fetch( "design:url/edit.tpl" );
$Result['path'] = array( array( 'url' => '/url/edit/',
                                'text' => ezpI18n::tr( 'kernel/url', 'URL edit' ) ) );
?>
