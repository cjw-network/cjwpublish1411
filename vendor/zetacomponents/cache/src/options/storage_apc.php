<?php
/**
 * File containing the ezcCacheStorageApcOptions class.
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
 * @package Cache
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * Option class for defining a connection to APC.
 *
 * @property string $lockKey
 *           Cache key to use for locking. Default is '.ezcLock'.
 * @property int $lockWaitTime
 *           Time to wait between lock availability checks. Measured in
 *           microseconds ({@link usleep()}). Default is 200000.
 * @property int $maxLockTime
 *           Time before a lock is considered dead, measured in seconds.
 *           Default is 5.
 * @property string $metaDataKey
 *           The name of the file used to store meta data. Default is
 *           '.ezcMetaData'.
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageApcOptions extends ezcBaseOptions
{
    /**
     * Parent storage options. 
     * 
     * @var ezcCacheStorageOptions
     */
    protected $storageOptions;

    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If $options contains a property not defined.
     * @throws ezcBaseValueException
     *         If $options contains a property with a value not allowed.
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        $this->properties['lockWaitTime'] = 200000;
        $this->properties['maxLockTime']  = 5;
        $this->properties['lockKey']      = '.ezcLock';
        $this->properties['metaDataKey']  = '.ezcMetaData';
        $this->storageOptions = new ezcCacheStorageOptions();

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the property $name is not defined.
     * @throws ezcBaseValueException
     *         If $value is not correct for the property $name.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'lockWaitTime':
            case 'maxLockTime':
                if ( !is_int( $value ) || $value < 1 )
                {
                    throw new ezcBaseValueException( $name, $value, 'int > 0' );
                }
                break;
            case 'lockKey':
            case 'metaDataKey':
                if ( !is_string( $value ) || strlen( $value ) < 1 )
                {
                    throw new ezcBaseValueException( $name, $value, 'string, length > 0' );
                }
                break;
            default:
                // Delegate
                $this->storageOptions->$name = $value;
        }
        $this->properties[$name] = $value;
    }

    /**
     * Returns the value of the option $name.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If the property $name is not defined.
     * @param string $name The name of the option to get
     * @return mixed The option value
     * @ignore
     */
    public function __get( $name )
    {
        if ( isset( $this->properties[$name] ) )
        {
            return $this->properties[$name];
        }

        // Delegate
        return $this->storageOptions->$name;
    }

    /**
     * Returns if option $name is defined.
     * 
     * @param string $name Option name to check for
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        return ( isset( $this->properties[$name] ) || isset( $this->storageOptions->$name ) );
    }

    /**
     * Merge an ezcCacheStorageOptions object into this object.
     * 
     * @param ezcCacheStorageOptions $options The options to merge.
     * @return void
     * @ignore
     */
    public function mergeStorageOptions( ezcCacheStorageOptions $options )
    {
        $this->storageOptions = $options;
    }
}
?>
