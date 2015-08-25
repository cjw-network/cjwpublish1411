<?php
/**
 * File containing the ezcCacheInvalidIdException
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
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception that is thrown if the given cache ID does not exist.
 * Caches must be created using {@link ezcCacheManager::createCache()} before 
 * they can be access using {@link ezcCacheManager::getCache()}. If you try to
 * access a non-existent cache ID, this exception will be thrown.
 *
 * @package Cache
 * @version //autogen//
 */
class ezcCacheInvalidIdException extends ezcCacheException
{
    /**
     * Creates a new ezcCacheInvalidIdException.
     * 
     * @param string $id The invalid ID.
     * @return void
     */
    function __construct( $id )
    {
        parent::__construct( "No cache or cache configuration known with ID '{$id}'." );
    }
}
?>
