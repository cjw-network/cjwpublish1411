<?php
/**
 * File containing the eZNotificationCollection class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZNotificationCollection eznotificationcollection.php
  \brief The class eZNotificationCollection does

*/
class eZNotificationCollection extends eZPersistentObject
{
    /*!
     Constructor
    */
    function eZNotificationCollection( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "event_id" => array( 'name' => "EventID",
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true,
                                                              'foreign_class' => 'eZNotificationEvent',
                                                              'foreign_attribute' => 'id',
                                                              'multiplicity' => '1..*' ),
                                         "handler" => array( 'name' => "Handler",
                                                             'datatype' => 'string',
                                                             'default' => '',
                                                             'required' => true ),
                                         "transport" => array( 'name' => "Transport",
                                                               'datatype' => 'string',
                                                               'default' => '',
                                                               'required' => true ),
                                         "data_subject" => array( 'name' => "DataText1",
                                                                'datatype' => 'text',
                                                                'default' => '',
                                                                'required' => true ),
                                         "data_text" => array( 'name' => "DataText2",
                                                                'datatype' => 'text',
                                                                'default' => '',
                                                                'required' => true ) ),
                      "keys" => array( "id" ),
                      "function_attributes" => array( 'items' => 'items',
                                                      'items_to_send' => 'itemsToSend',
                                                      'item_count' => 'itemCount' ),
                      "increment_key" => "id",
                      "sort" => array( "id" => "asc" ),
                      "class_name" => "eZNotificationCollection",
                      "name" => "eznotificationcollection" );
    }


    static function create( $eventID, $handler, $transport )
    {
        return new eZNotificationCollection( array( 'event_id' => $eventID,
                                                    'handler' => $handler,
                                                    'transport' => $transport ) );
    }

    function addItem( $address, $sendDate = 0 )
    {
        $item = eZNotificationCollectionItem::create( $this->attribute( 'id' ), $this->attribute( 'event_id' ), $address, $sendDate = 0  );
        $item->store();
        return $item;
    }

    function items()
    {
        return eZPersistentObject::fetchObjectList( eZNotificationCollectionItem::definition(),
                                                    null, array( 'collection_id' => $this->attribute( 'id' ) ), null,null,
                                                    true );
    }

    function itemCount()
    {
        $result = eZPersistentObject::fetchObjectList( eZNotificationCollectionItem::definition(),
                                                       array(),
                                                       array( 'collection_id' => $this->attribute( 'id' ) ),
                                                       false,
                                                       null,
                                                       false,
                                                       false,
                                                       array( array( 'operation' => 'count( * )',
                                                                     'name' => 'count' ) ) );
        return $result[0]['count'];
    }

    function itemsToSend()
    {
        return eZPersistentObject::fetchObjectList( eZNotificationCollectionItem::definition(),
                                                    null, array( 'collection_id' => $this->attribute( 'id' ),
                                                                 'send_date' => 0 ),
                                                    null, null, true );
    }

    static function fetchForHandler( $handler, $eventID, $transport )
    {
        return eZPersistentObject::fetchObject( eZNotificationCollection::definition(), null,
                                                array( 'event_id' => $eventID,
                                                       'handler'=> $handler,
                                                       'transport' => $transport ) );
    }

    static function fetchListForHandler( $handler, $eventID, $transport )
    {
        return eZPersistentObject::fetchObjectList( eZNotificationCollection::definition(), null,
                                                    array( 'event_id' => $eventID,
                                                           'handler'=> $handler,
                                                           'transport' => $transport ) );
    }

    /*!
     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     the calls within a db transaction; thus within db->begin and db->commit.
     */
    static function removeEmpty()
    {
        $db = eZDB::instance();
        if ( $db->databaseName() == 'oracle' ) // fix for compatibility with Oracle versions prior to 9
            $query = 'SELECT eznotificationcollection.id FROM eznotificationcollection, eznotificationcollection_item
                      WHERE  eznotificationcollection.id = eznotificationcollection_item.collection_id(+) AND
                             eznotificationcollection_item.collection_id IS NULL';
        else
            $query = 'SELECT eznotificationcollection.id FROM eznotificationcollection
                      LEFT JOIN eznotificationcollection_item ON eznotificationcollection.id=eznotificationcollection_item.collection_id
                      WHERE eznotificationcollection_item.collection_id IS NULL';

        $idArray = $db->arrayQuery( $query );

        $db->begin();
        foreach ( $idArray as $id )
        {
            eZPersistentObject::removeObject( eZNotificationCollection::definition(), array( 'id' => $id['id'] ) );
        }
        $db->commit();
    }

    /*!
     \static
     Removes all notification collections.
     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     the calls within a db transaction; thus within db->begin and db->commit.
    */
    static function cleanup()
    {
        $db = eZDB::instance();
        $db->begin();
        eZNotificationCollectionItem::cleanup();
        $db->query( "DELETE FROM eznotificationcollection" );
        $db->commit();
    }
}

?>
