<?php
/**
 * File containing the ezcCacheStorageObject class.
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
 * This cache storage implementation stores arrays, scalar values
 * (int, float, string, bool) and objects implementing ezcBaseExportable in 
 * files on your hard disk as PHP code. This makes
 * the restoring of cache data extremly fast, since the stored data is simply
 * included and parsed by the PHP interpreter. It takes its base methods from
 * the extended storage base class {@link ezcCacheStorageFile}.
 *
 * This cache storage deprecates {@link ezcCacheStorageFileArray}, since it is 
 * also capable of storing exportable objects in addition to arrays and scalar 
 * values.
 *
 * For example code of using a cache storage, see {@link ezcCacheManager}.
 *
 * The Cache package contains several other implementations of 
 * {@link ezcCacheStorageFile}. As there are:
 *
 * - ezcCacheStorageFileEvalArray
 * - ezcCacheStorageFilePlain
 *
 * Both of these use different methods for actually storing the data, which are 
 * basically not superior to the implementation in this class. 
 * 
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageFileObject extends ezcCacheStorageFile
{
    /**
     * Fetch data from the cache.
     *
     * This method fetches the desired data from the file with $filename from 
     * disk. This implementation uses an include statement for fetching. The 
     * return value depends on the stored data and might either be an object
     * implementing {@link ezcBaseExportable}, an array or a scalar value.
     * 
     * @param string $filename
     * @return mixed 
     */
    protected function fetchData( $filename )
    {
        return ( include $filename );
    }

    /**
     * Serialize the data for storing.
     *
     * Serializes the given $data to a executable PHP code representation 
     * string. This works with objects implementing {@link ezcBaseExportable},
     * arrays and scalar values (int, bool, float, string). The return value is
     * executable PHP code to be stored to disk. The data can be unserialized 
     * using the {@link fetchData()} method.
     * 
     * @param mixed $data
     * @return string
     *
     * @throws ezcCacheInvalidDataException
     *         if the $data can not be serialized (e.g. an object that does not
     *         implement ezcBaseExportable, a resource, ...).
     */
    protected function prepareData( $data )
    {
        if ( ( is_object( $data ) && !( $data instanceof ezcBaseExportable ) )
             || is_resource( $data ) )
        {
            throw new ezcCacheInvalidDataException( gettype( $data ), array( 'simple', 'array', 'ezcBaseExportable' ) );
        }
        return "<?php\nreturn " . var_export( $data, true ) . ";\n?>\n";
    }
}
?>
