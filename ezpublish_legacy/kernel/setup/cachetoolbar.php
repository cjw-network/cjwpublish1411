<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$http = eZHTTPTool::instance();
$module = $Params['Module'];

$cacheType = $module->actionParameter( 'CacheType' );

eZPreferences::setValue( 'admin_clearcache_type', $cacheType );

if ( $module->hasActionParameter ( 'NodeID' ) )
    $nodeID = $module->actionParameter( 'NodeID' );

if ( $module->hasActionParameter ( 'ObjectID' ) )
    $objectID = $module->actionParameter( 'ObjectID' );

if ( $cacheType == 'All' )
{
    eZCache::clearAll();
}
elseif ( $cacheType == 'Template' )
{
    eZCache::clearByTag( 'template' );
}
elseif ( $cacheType == 'Content' )
{
    eZCache::clearByTag( 'content' );
}
elseif ( $cacheType == 'TemplateContent' )
{
    eZCache::clearByTag( 'template' );
    eZCache::clearByTag( 'content' );
}
elseif ( $cacheType == 'Ini' )
{
    eZCache::clearByTag( 'ini' );
}
elseif ( $cacheType == 'Static' )
{
    // get staticCacheHandler instance
    $optionArray = array( 'iniFile'      => 'site.ini',
                          'iniSection'   => 'ContentSettings',
                          'iniVariable'  => 'StaticCacheHandler' );

    $options = new ezpExtensionOptions( $optionArray );
    $staticCacheHandler = eZExtension::getHandlerClass( $options );

    $staticCacheHandler->generateCache( true, true );
    $cacheCleared['static'] = true;
}
elseif ( $cacheType == 'ContentNode' )
{
    $contentModule = eZModule::exists( 'content' );
    if ( $contentModule instanceof eZModule )
    {
        $contentModule->setCurrentAction( 'ClearViewCache', 'action' );

        $contentModule->setActionParameter( 'NodeID', $nodeID, 'action' );
        $contentModule->setActionParameter( 'ObjectID', $objectID, 'action' );

        $contentModule->run( 'action', array( $nodeID, $objectID) );
    }
}
elseif ( $cacheType == 'ContentSubtree' )
{
    $contentModule = eZModule::exists( 'content' );
    if ( $contentModule instanceof eZModule )
    {
        $contentModule->setCurrentAction( 'ClearViewCacheSubtree', 'action' );

        $contentModule->setActionParameter( 'NodeID', $nodeID, 'action' );
        $contentModule->setActionParameter( 'ObjectID', $objectID, 'action' );

        $contentModule->run( 'action', array( $nodeID, $objectID) );
    }
}

$uri = $http->postVariable( 'RedirectURI', $http->sessionVariable( 'LastAccessedModifyingURI', '/' ) );
$module->redirectTo( $uri );

?>
