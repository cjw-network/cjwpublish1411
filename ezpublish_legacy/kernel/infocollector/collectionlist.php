<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$http = eZHTTPTool::instance();
$module = $Params['Module'];
$objectID = $Params['ObjectID'];
$offset = $Params['Offset'];

if( !is_numeric( $offset ) )
{
    $offset = 0;
}


if( $module->isCurrentAction( 'RemoveCollections' ) && $http->hasPostVariable( 'CollectionIDArray' ) )
{
    $collectionIDArray = $http->postVariable( 'CollectionIDArray' );
    $http->setSessionVariable( 'CollectionIDArray', $collectionIDArray );
    $http->setSessionVariable( 'ObjectID', $objectID );

    $collections = count( $collectionIDArray );

    $tpl = eZTemplate::factory();
    $tpl->setVariable( 'module', $module );
    $tpl->setVariable( 'collections', $collections );
    $tpl->setVariable( 'object_id', $objectID );
    $tpl->setVariable( 'remove_type', 'collections' );

    $Result = array();
    $Result['content'] = $tpl->fetch( 'design:infocollector/confirmremoval.tpl' );
    $Result['path'] = array( array( 'url' => false,
                                    'text' => ezpI18n::tr( 'kernel/infocollector', 'Collected information' ) ) );
    return;
}


if( $module->isCurrentAction( 'ConfirmRemoval' ) )
{
    $collectionIDArray = $http->sessionVariable( 'CollectionIDArray' );

    if( is_array( $collectionIDArray ) )
    {
        foreach( $collectionIDArray as $collectionID )
        {
            eZInformationCollection::removeCollection( $collectionID );
        }
    }

    $objectID = $http->sessionVariable( 'ObjectID' );
    $module->redirectTo( '/infocollector/collectionlist/' . $objectID );
}


if( eZPreferences::value( 'admin_infocollector_list_limit' ) )
{
    switch( eZPreferences::value( 'admin_infocollector_list_limit' ) )
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

$object = false;

if( is_numeric( $objectID ) )
{
    $object = eZContentObject::fetch( $objectID );
}

if( !$object )
{
    return $module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

$collections = eZInformationCollection::fetchCollectionsList( $objectID, /* object id */
                                                              false, /* creator id */
                                                              false, /* user identifier */
                                                              array( 'limit' => $limit,'offset' => $offset ) /* limit array */ );
$numberOfCollections = eZInformationCollection::fetchCollectionsCount( $objectID );

$viewParameters = array( 'offset' => $offset );
$objectName = $object->attribute( 'name' );

$tpl = eZTemplate::factory();
$tpl->setVariable( 'module', $module );
$tpl->setVariable( 'limit', $limit );
$tpl->setVariable( 'view_parameters', $viewParameters );
$tpl->setVariable( 'object', $object );
$tpl->setVariable( 'collection_array', $collections );
$tpl->setVariable( 'collection_count', $numberOfCollections );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:infocollector/collectionlist.tpl' );
$Result['path'] = array( array( 'url' => '/infocollector/overview',
                                'text' => ezpI18n::tr( 'kernel/infocollector', 'Collected information' ) ),
                         array( 'url' => false,
                                'text' => $objectName ) );

?>
