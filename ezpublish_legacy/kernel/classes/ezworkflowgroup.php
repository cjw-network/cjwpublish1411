<?php
/**
 * File containing the eZWorkflowGroup class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
 \class eZWorkflowGroup ezworkflowgroup.php
 \brief Handles grouping of workflows

*/

class eZWorkflowGroup extends eZPersistentObject
{
    function eZWorkflowGroup( $row )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "name" => array( 'name' => "Name",
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true,
                                                          'max_length' => 255 ),
                                         "creator_id" => array( 'name' => "CreatorID",
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true,
                                                                'foreign_class' => 'eZUser',
                                                                 'foreign_attribute' => 'contentobject_id',
                                                                 'multiplicity' => '1..*' ),
                                         "modifier_id" => array( 'name' => "ModifierID",
                                                                 'datatype' => 'integer',
                                                                 'default' => 0,
                                                                 'required' => true,
                                                                 'foreign_class' => 'eZUser',
                                                                 'foreign_attribute' => 'contentobject_id',
                                                                 'multiplicity' => '1..*' ),
                                         "created" => array( 'name' => "Created",
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         "modified" => array( 'name' => "Modified",
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ) ),
                      "keys" => array( "id" ),
                      'function_attributes' => array( 'creator' => 'creator',
                                                      'modifier' => 'modifier' ),
                      "increment_key" => "id",
                      "class_name" => "eZWorkflowGroup",
                      "sort" => array( "name" => "asc" ),
                      "name" => "ezworkflow_group" );
    }

    static function create( $user_id )
    {
        $date_time = time();
        $row = array(
            "id" => null,
            "name" => "",
            "creator_id" => $user_id,
            "modifier_id" => $user_id,
            "created" => $date_time,
            "modified" => $date_time );
        return new eZWorkflowGroup( $row );
    }

    static function fetch( $id, $asObject = true )
    {
        return eZPersistentObject::fetchObject( eZWorkflowGroup::definition(),
                                                null,
                                                array( "id" => $id ),
                                                $asObject );
    }

    static function fetchList( $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( eZWorkflowGroup::definition(),
                                                    null, null, null, null,
                                                    $asObject );
    }

    /*!
     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     the calls within a db transaction; thus within db->begin and db->commit.
     */
    static function removeSelected ( $id )
    {
        eZPersistentObject::removeObject( eZWorkflowGroup::definition(),
                                          array( "id" => $id ) );
    }

    function creator()
    {
        if ( isset( $this->CreatorID ) and $this->CreatorID )
        {
            return eZUser::fetch( $this->CreatorID );
        }
        return null;
    }

    function modifier()
    {
        if ( isset( $this->ModifierID ) and $this->ModifierID )
        {
            return eZUser::fetch( $this->ModifierID );
        }
        return null;
    }

    /// \privatesection
    public $ID;
    public $Name;
    public $CreatorID;
    public $ModifierID;
    public $Created;
    public $Modified;
}

?>
