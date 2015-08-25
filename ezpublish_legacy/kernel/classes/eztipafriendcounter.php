<?php
/**
 * File containing the eZTipafriendCounter class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

//!! eZKernel
//! The class eZTipafriendCounter
/*!

*/

class eZTipafriendCounter extends eZPersistentObject
{
    function eZTipafriendCounter( $row )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( 'fields' => array( 'node_id' => array( 'name' => 'NodeID',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true,
                                                             'foreign_class' => 'eZContentObjectTreeNode',
                                                             'foreign_attribute' => 'node_id',
                                                             'multiplicity' => '1..*' ),
                                         'count' => array( 'name' => 'Count', // deprecated column, must not be used
                                                           'datatype' => 'integer',
                                                           'default' => 0,
                                                           'required' => true ),
                                         'requested' => array( 'name' => 'Requested',
                                                               'datatype' => 'integer',
                                                               'default' => 0,
                                                               'required' => true ) ),
                      'keys' => array( 'node_id', 'requested' ),
                      'relations' => array( 'node_id' => array( 'class' => 'eZContentObjectTreeNode',
                                                                'field' => 'node_id' ) ),
                      'class_name' => 'eZTipafriendCounter',
                      'sort' => array( 'count' => 'desc' ),
                      'name' => 'eztipafriend_counter' );
    }

    static function create( $nodeID )
    {
        return new eZTipafriendCounter( array( 'node_id' => $nodeID,
                                               'count' => 0,
                                               'requested' => time() ) );
    }

    /*!
     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     the calls within a db transaction; thus within db->begin and db->commit.
     */
    static function removeForNode( $nodeID )
    {
        eZPersistentObject::removeObject( eZTipafriendCounter::definition(),
                                          array( 'node_id' => $nodeID ) );
    }

    static function fetch( $nodeID, $asObject = true )
    {
        return eZPersistentObject::fetchObject( eZTipafriendCounter::definition(),
                                                null,
                                                array( 'node_id' => $nodeID ),
                                                $asObject );
    }

    /*!
     \static
     Removes all counters for tipafriend functionality.
     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     the calls within a db transaction; thus within db->begin and db->commit.
    */
    static function cleanup()
    {
        $db = eZDB::instance();
        $db->query( "DELETE FROM eztipafriend_counter" );
    }

    /// \privatesection
    public $NodeID;
    public $Count;
}

?>
