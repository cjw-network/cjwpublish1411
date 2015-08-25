<?php
/**
 * File containing the indexcontent.php cronjob
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$cli->output( "Starting processing pending search engine modifications" );

$contentObjects = array();
$db = eZDB::instance();

$offset = 0;
$limit = 50;

$searchEngine = eZSearch::getEngine();

if ( !$searchEngine instanceof ezpSearchEngine )
{
    $cli->error( "The configured search engine does not implement the ezpSearchEngine interface or can't be found." );
    $script->shutdown( 1 );
}

$needRemoveWithUpdate = $searchEngine->needRemoveWithUpdate();

while( true )
{
    $entries = $db->arrayQuery(
        "SELECT param FROM ezpending_actions WHERE action = 'index_object' GROUP BY param ORDER BY min(created)",
        array( 'limit' => $limit, 'offset' => $offset )
    );

    if ( is_array( $entries ) && count( $entries ) != 0 )
    {
        foreach ( $entries as $entry )
        {
            $objectID = (int)$entry['param'];

            $cli->output( "\tIndexing object ID #$objectID" );
            $db->begin();
            $object = eZContentObject::fetch( $objectID );
            $removeFromPendingActions = true;
            if ( $object )
            {
                if ( $needRemoveWithUpdate )
                {
                    $searchEngine->removeObject( $object, false );
                }
                $removeFromPendingActions = $searchEngine->addObject( $object, false );
            }

            if ( $removeFromPendingActions )
            {
                $db->query( "DELETE FROM ezpending_actions WHERE action = 'index_object' AND param = '$objectID'" );
            }
            else
            {
                $cli->warning( "\tFailed indexing object ID #$objectID, keeping it in the queue." );
                // Increase the offset to skip failing objects
                ++$offset;
            }

            $db->commit();
        }

        $searchEngine->commit();
        // clear object cache to conserve memory
        eZContentObject::clearCache();
    }
    else
    {
        break; // No valid result from ezpending_actions
    }
}

$cli->output( "Done" );

?>
