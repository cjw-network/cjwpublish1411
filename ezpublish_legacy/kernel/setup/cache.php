<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$http = eZHTTPTool::instance();
$module = $Params['Module'];


$ini = eZINI::instance( );
$tpl = eZTemplate::factory();

$cacheList = eZCache::fetchList();

$cacheCleared = array( 'all' => false,
                       'content' => false,
                       'ini' => false,
                       'template' => false,
                       'list' => false,
                       'static' => false );

$contentCacheEnabled = $ini->variable( 'ContentSettings', 'ViewCaching' ) == 'enabled';
$iniCacheEnabled = true;
$templateCacheEnabled = $ini->variable( 'TemplateSettings', 'TemplateCache' ) == 'enabled';

$cacheEnabledList = array();
foreach ( $cacheList as $cacheItem )
{
    $cacheEnabledList[$cacheItem['id']] = $cacheItem['enabled'];
}

$cacheEnabled = array( 'all' => true,
                       'content' => $contentCacheEnabled,
                       'ini' => $iniCacheEnabled,
                       'template' => $templateCacheEnabled,
                       'list' => $cacheEnabledList );

if ( $module->isCurrentAction( 'ClearAllCache' ) )
{
    eZCache::clearAll();
    $cacheCleared['all'] = true;
}

if ( $module->isCurrentAction( 'ClearContentCache' ) )
{
    eZCache::clearByTag( 'content' );
    $cacheCleared['content'] = true;
}

if ( $module->isCurrentAction( 'ClearINICache' ) )
{
    eZCache::clearByTag( 'ini' );
    $cacheCleared['ini'] = true;
}

if ( $module->isCurrentAction( 'ClearTemplateCache' ) )
{
    eZCache::clearByTag( 'template' );
    $cacheCleared['template'] = true;
}

if ( $module->isCurrentAction( 'ClearCache' ) && $module->hasActionParameter( 'CacheList' ) && is_array( $module->actionParameter( 'CacheList' ) ) )
{
    $cacheClearList = $module->actionParameter( 'CacheList' );
    eZCache::clearByID( $cacheClearList );
    $cacheItemList = array();
    foreach ( $cacheClearList as $cacheClearItem )
    {
        foreach ( $cacheList as $cacheItem )
        {
            if ( $cacheItem['id'] == $cacheClearItem )
            {
                $cacheItemList[] = $cacheItem;
                break;
            }
        }
    }
    $cacheCleared['list'] = $cacheItemList;
}

if ( $module->isCurrentAction( 'RegenerateStaticCache' ) )
{
    // get staticCacheHandler instance
    $optionArray = array( 'iniFile'      => 'site.ini',
                          'iniSection'   => 'ContentSettings',
                          'iniVariable'  => 'StaticCacheHandler' );

    $options = new ezpExtensionOptions( $optionArray );
    $staticCacheHandler = eZExtension::getHandlerClass( $options );
	
    $staticCacheHandler->generateCache( true, true );

    $staticCacheHandlerClassName = $ini->variable( 'ContentSettings', 'StaticCacheHandler' );
    $staticCacheHandlerClassName::executeActions();

    $cacheCleared['static'] = true;
}

$tpl->setVariable( "cache_cleared", $cacheCleared );
$tpl->setVariable( "cache_enabled", $cacheEnabled );
$tpl->setVariable( 'cache_list', $cacheList );


$Result = array();
$Result['content'] = $tpl->fetch( "design:setup/cache.tpl" );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'kernel/setup', 'Cache admin' ) ) );

?>
