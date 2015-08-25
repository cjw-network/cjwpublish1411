<?php
/**
 * File containing the ezcWebdavCreationDateProperty class.
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
 * @package Webdav
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * An object of this class represents the Webdav property <creationdate>.
 *
 * @property ezcWebdavDateTime $date
 *           The creation date.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavCreationDateProperty extends ezcWebdavLiveProperty
{
    /**
     * Creates a new ezcWebdavCreationDateProperty.
     *
     * The given $date object represents the time value stored in the property.
     * 
     * @param ezcWebdavDateTime $date The date value.
     * @return void
     */
    public function __construct( ezcWebdavDateTime $date = null )
    {
        parent::__construct( 'creationdate' );

        $this->date = $date;
    }

    /**
     * Sets a property.
     *
     * This method is called when an property is to be set.
     * 
     * @param string $propertyName The name of the property to set.
     * @param mixed $propertyValue The property value.
     * @return void
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBaseValueException
     *         if the value to be assigned to a property is invalid.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a read-only property.
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'date':
                if ( !( $propertyValue instanceof ezcWebdavDateTime ) && $propertyValue !== null )
                {
                    return $this->hasError( $propertyName, $propertyValue, 'ezcWebdavDateTime' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }

    /**
     * Returns if property has no content.
     *
     * Returns true, if the property has no content stored.
     * 
     * @access public
     * @return bool
     */
    public function hasNoContent()
    {
        return $this->properties['date'] === null;
    }
}

?>
