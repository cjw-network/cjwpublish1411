<?php
/**
 * File containing the ezcWebdavFileBackendOptions class
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
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Class containing the options for the file backend.
 *
 * An instance of this class is created an hold in {@link ezcWebdavFileBackend}
 * instances. Using these options the behavior of the file backend can be
 * changed.
 *
 * @property bool $noLock
 *           If locking should be used internally in the back end, to ensure 
 *           operations are atomic.
 * @property int $waitForLock
 *           Time to wait between check if a lock can be acquired, in
 *           microseconds.
 * @property float $lockTimeout
 *           Timeout in seconds after which a lock is considered dead and 
 *           therefore removed.
 * @property string $lockFileName
 *           Name used for the lock file.
 * @property string $propertyStoragePath
 *           Name used for property storage paths
 * @property int $directoryMode
 *           Mode directories are created with.
 * @property int $fileMode
 *           Mode files are created with.
 * @property bool $useMimeExts
 *           Indicates wheather to use PHPs extensions to receive the correct
 *           mime time for a file instead of just returning the mime type
 *           originally set by the client.
 * @property bool $hideDotFiles
 *           Indicates wheather to hide files starting with a dot
 *
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavFileBackendOptions extends ezcBaseOptions
{
    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if $options contains a property not defined
     * @throws ezcBaseValueException
     *         if $options contains a property with a value not allowed
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        $this->properties['noLock']                 = false;
        $this->properties['waitForLock']            = 200000;
        $this->properties['lockTimeout']            = 2;
        $this->properties['lockFileName']           = '.ezc_lock';
        $this->properties['propertyStoragePath']    = '.ezc';
        $this->properties['directoryMode']          = 0755;
        $this->properties['fileMode']               = 0644;
        $this->properties['useMimeExts']            = true;
        $this->properties['hideDotFiles']           = true;

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name
     * @param mixed $value
     * @return void
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'noLock':
            case 'useMimeExts':
            case 'hideDotFiles':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }

                $this->properties[$name] = $value;
                break;

            case 'lockFileName':
            case 'propertyStoragePath':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'regular expression' );
                }

                $this->properties[$name] = $value;
                break;

            case 'waitForLock':
            case 'fileMode':
            case 'directoryMode':
                if ( !is_int( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'integer' );
                }

                $this->properties[$name] = $value;
                break;

            case 'lockTimeout':
                if ( !is_numeric( $value ) || $value < 0 )
                {
                    throw new ezcBaseValueException( $name, $value, 'float > 0' );
                }

                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }
}

?>
