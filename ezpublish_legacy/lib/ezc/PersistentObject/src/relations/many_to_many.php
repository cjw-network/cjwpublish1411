<?php
/**
 * File containing the ezcPersistentManyToManyRelation.
 *
 * @package PersistentObject
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Relation class to reflect a many-to-many table relation (m:n).
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentManyToManyRelation extends ezcPersistentRelation
{
    /**
     * Constructs a new many to many relation from the table $sourceTable to
     * the table $destinationTable via $relationTable
     *
     * @param string $sourceTable
     * @param string $destinationTable
     * @param string $relationTable
     */
    public function __construct( $sourceTable, $destinationTable, $relationTable )
    {
        $this->properties['relationTable'] = null;

        $this->sourceTable      = $sourceTable;
        $this->destinationTable = $destinationTable;
        $this->relationTable    = $relationTable;
    }

    /**
     * Validates an {@link ezcPersistentRelation::$columnMap} property.
     * Checks is the given array represents a valid $columnMap property. Column
     * maps for this kind of relation may only contain instances of
     * {@link ezcPersistentDoubleTableMap} and have to at least contain 1
     * instance.
     *  
     * @param array $columnMap The column map to check.
     *
     * @throws ezcBaseValueException On an invalid column map.
     */
    protected function validateColumnMap( array $columnMap )
    {
        if ( sizeof( $columnMap ) < 1 )
        {
            throw new ezcBaseValueException(
                "colmunMap",
                $columnMap,
                "array(ezcPersistentDoubleTableMap) > 0 elements"
            );
        }
        foreach ( $columnMap as $relation )
        {
            if ( !( $relation instanceof ezcPersistentDoubleTableMap ) )
            {
                throw new ezcBaseValueException(
                    "columnMap",
                    $columnMap,
                    "array(ezcPersistentDoubleTableMap) > 0 elements"
                );
            }
        }
    }

    /**
     * Property read access.
     * 
     * @param string $propertyName Name of the property.
     * @return mixed Value of the property or null.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the the desired property is not found.
     * @ignore
     */
    public function __get( $propertyName )
    {
        switch ( $propertyName )
        {
            case "relationTable":
                return $this->properties[$propertyName];
            default:
                return parent::__get( $propertyName );
        }

    }

    /**
     * Property write access.
     * 
     * @param string $propertyName Name of the property.
     * @param mixed $propertyValue  The value for the property.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case "relationTable":
                if ( !is_string( $propertyValue ) )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        "string"
                    );
                }
                $this->properties[$propertyName] = $propertyValue;
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                break;
        }
    }

    /**
     * Property isset access.
     * 
     * @param string $propertyName Name of the property.
     * @return bool True is the property is set, otherwise false.
     * @ignore
     */
    public function __isset( $propertyName )
    {
        if ( array_key_exists( $propertyName, $this->properties ) )
        {
            return true;
        }
        return parent::__isset( ( $propertyName ) );
    }

    /**
     * Sets the state after importing an exported object.
     * 
     * @param array $state 
     * @return void
     */
    public static function __set_state( array $state )
    {
        $rel = new ezcPersistentManyToManyRelation( 
            $state['properties']['sourceTable'],
            $state['properties']['destinationTable'],
            $state['properties']['relationTable']
        );
        $rel->properties = $state['properties'];
        return $rel;
    }
}

?>
