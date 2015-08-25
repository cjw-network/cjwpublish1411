<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$Module = $Params['Module'];
$urlID = $Params['ID'];

if( eZPreferences::value( 'admin_url_view_limit' ) )
{
    switch( eZPreferences::value( 'admin_url_view_limit' ) )
    {
        case '2': { $limit = 25; } break;
        case '3': { $limit = 50; } break;
        default:  { $limit = 10; } break;
    }
}
else
{
    $limit = 10;
}

$offset = $Params['Offset'];
if ( !is_numeric( $offset ) )
{
    $offset = 0;
}

$url = eZURL::fetch( $urlID );
if ( !$url )
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );

$link = $url->attribute( 'url' );
if ( preg_match("/^(http:)/i", $link ) or
     preg_match("/^(ftp:)/i", $link ) or
     preg_match("/^(https:)/i", $link ) or
     preg_match("/^(file:)/i", $link ) or
     preg_match("/^(mailto:)/i", $link ) )
{
    // No changes
}
else
{
    $domain = getenv( 'HTTP_HOST' );
    $protocol = eZSys::serverProtocol();

    $preFix = $protocol . "://" . $domain;
    $preFix .= eZSys::wwwDir();

    $link = preg_replace("/^\//e", "", $link );
    $link = $preFix . "/" . $link;
}

$viewParameters = array( 'offset' => $offset, 'limit'  => $limit );
$http = eZHTTPTool::instance();
$objectList = eZURLObjectLink::fetchObjectVersionList( $urlID, $viewParameters );
$urlViewCount= eZURLObjectLink::fetchObjectVersionCount( $urlID );

if ( $Module->isCurrentAction( 'EditObject' ) )
{
    if ( $http->hasPostVariable( 'ObjectList' ) )
    {
        $versionID = $http->postVariable( 'ObjectList' );
        $version = eZContentObjectVersion::fetch( $versionID );
        $contentObjectID = $version->attribute( 'contentobject_id' );
        $versionNr = $version->attribute( 'version' );
        $Module->redirect( 'content', 'edit', array( $contentObjectID, $versionNr ) );
    }
}


$tpl = eZTemplate::factory();

$tpl->setVariable( 'Module', $Module );
$tpl->setVariable( 'url_object', $url );
$tpl->setVariable( 'full_url', $link );
$tpl->setVariable( 'object_list', $objectList );
$tpl->setVariable( 'view_parameters', $viewParameters );
$tpl->setVariable( 'url_view_count', $urlViewCount );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:url/view.tpl' );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'kernel/url', 'URL' ) ),
                         array( 'url' => false,
                                'text' => ezpI18n::tr( 'kernel/url', 'View' ) ) );

?>
