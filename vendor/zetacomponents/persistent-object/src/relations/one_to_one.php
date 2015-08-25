<?php
/**
 * File containing the ezcPersistentOneToOneRelation.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package PersistentObject
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Relation class to reflect a one-to-one table relation (1:1).
 *
 * @property bool $cascade
 *           Wether to cascade delete action from the source table to the
 *           destination table.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentOneToOneRelation extends ezcPersistentRelation
{
    /**
     * Create a new relation.
     *
     * @param string $sourceTable      See property $sourceTable
     * @param string $destinationTable See property $destinationTable
     */
    public function __construct( $sourceTable, $destinationTable )
    {
        parent::__construct( $sourceTable, $destinationTable );
        $this->properties['cascade'] = false;
    }

    /**
     * Validates an {@link ezcPersistentRelation::$columnMap} property.
     * Checks is the given array represents a valid $columnMap property. Column
     * maps for this kind of relation may only contain instances of
     * {@link ezcPersistentSingleTableMap} and have to at least contain 1
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
                "array(ezcPersistentSingleTableMap) > 0 elements"
            );
        }
        foreach ( $columnMap as $relation )
        {
            if ( !( $relation instanceof ezcPersistentSingleTableMap ) )
            {
                throw new ezcBaseValueException(
                    "columnMap",
                    $columnMap,
                    "array(ezcPersistentSingleTableMap) > 0 elements"
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
            case "cascade":
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
            case "cascade":
                if ( !is_bool( $propertyValue ) )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        "bool"
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
        $rel = new ezcPersistentOneToOneRelation( 
            $state['properties']['sourceTable'],
            $state['properties']['destinationTable']
        );
        $rel->properties = $state['properties'];
        return $rel;
    }
}

?>
