<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

if ( eZPreferences::value( 'admin_search_stats_limit' ) )
{
    switch ( eZPreferences::value( 'admin_search_stats_limit' ) )
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

$http = eZHTTPTool::instance();
$module = $Params['Module'];

if ( $module->isCurrentAction( 'ResetSearchStats' ) )
{
    eZSearchLog::removeStatistics();
}

$viewParameters = array( 'offset' => $offset, 'limit'  => $limit );
$tpl = eZTemplate::factory();

$db = eZDB::instance();
$query = "SELECT count(*) as count FROM ezsearch_search_phrase";
$searchListCount = $db->arrayQuery( $query );

$mostFrequentPhraseArray = eZSearchLog::mostFrequentPhraseArray( $viewParameters );

$tpl->setVariable( "view_parameters", $viewParameters );
$tpl->setVariable( "most_frequent_phrase_array", $mostFrequentPhraseArray );
$tpl->setVariable( "search_list_count", $searchListCount[0]['count'] );

$Result = array();
$Result['content'] = $tpl->fetch( "design:search/stats.tpl" );
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/search', 'Search stats' ),
                                'url' => false ) );

?>
