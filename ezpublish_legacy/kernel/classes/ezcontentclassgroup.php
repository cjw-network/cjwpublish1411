<?php
/**
 * File containing the eZContentClassGroup class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

//!! eZKernel
//! The class eZContentClassGroup
/*!

*/

class eZContentClassGroup extends eZPersistentObject
{
    function eZContentClassGroup( $row )
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
                                                          'required' => true ),
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
                      'function_attributes' => array( 'modifier' => 'modifier',
                                                      'creator' => 'creator' ),
                      "increment_key" => "id",
                      "class_name" => "eZContentClassGroup",
                      "sort" => array( "id" => "asc" ),
                      "name" => "ezcontentclassgroup" );
    }

    static function create( $userID = false )
    {
        $dateTime = time();
        if ( !$userID )
            $userID = eZUser::currentUserID();
        $row = array(
            "id" => null,
            "name" => "",
            "creator_id" => $userID,
            "modifier_id" => $userID,
            "created" => $dateTime,
            "modified" => $dateTime );
        return new eZContentClassGroup( $row );
    }

    function modifier()
    {
        if ( isset( $this->ModifierID ) and $this->ModifierID )
        {
            return eZUser::fetch( $this->ModifierID );
        }
        return null;
    }

    function creator()
    {
        if ( isset( $this->CreatorID ) and $this->CreatorID )
        {
            return eZUser::fetch( $this->CreatorID );
        }
        return null;
    }

    /*!
     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     the calls within a db transaction; thus within db->begin and db->commit.
     */
    static function removeSelected( $id )
    {
        eZPersistentObject::removeObject( eZContentClassGroup::definition(),
                                          array( "id" => $id ) );
    }

    /*!
     Fetch Class group by name, and return first result.

     \param name
     \param asObject
    */
    static function fetchByName( $name, $asObject = true )
    {
        $conds = array( 'name' => $name );
        return eZPersistentObject::fetchObject( eZContentClassGroup::definition(),
                                                null,
                                                $conds,
                                                $asObject );
    }

    static function fetch( $id, $user_id = false, $asObject = true )
    {
        $conds = array( "id" => $id );
        if ( $user_id !== false and is_numeric( $user_id ) )
            $conds["creator_id"] = $user_id;
        return eZPersistentObject::fetchObject( eZContentClassGroup::definition(),
                                                null,
                                                $conds,
                                                $asObject );
    }

    static function fetchList( $user_id = false, $asObject = true )
    {
        $conds = array();
        if ( $user_id !== false and is_numeric( $user_id ) )
            $conds["creator_id"] = $user_id;
        return eZPersistentObject::fetchObjectList( eZContentClassGroup::definition(),
                                                    null, $conds, null, null,
                                                    $asObject );
    }

    /*!
     Appends the class \a $class to this group.
     \param $class Can either be an eZContentClass object or a class ID.
     \return the class group link object.
     \note tranaction unsafe.
    */
    function appendClass( $class, $version = false )
    {
        if ( $class instanceof eZContentClass )
        {
            $classID = $class->attribute( 'id' );
            $version = $class->attribute( 'version' );
        }
        else
        {
            $classID = $class;
        }
        $classGroupLink = eZContentClassClassGroup::create( $classID,
                                                            $version,
                                                            $this->attribute( 'id' ),
                                                            $this->attribute( 'name' ) );
        $classGroupLink->store();
        return $classGroupLink;
    }

    public $ID;
    public $Name;
    public $CreatorID;
    public $ModifierID;
    public $Created;
    public $Modified;
}

?>
