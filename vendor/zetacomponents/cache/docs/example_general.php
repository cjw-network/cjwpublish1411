<?php
/**
 * General example for the Cache component.
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

require_once 'Base/src/base.php';

// Some pre-work, needed by the example
$basePath = dirname( __FILE__ ).'/cache';
function getUniqueId()
{
    return 'This is a unique ID';
}

/**
 * Autoload ezc classes 
 * 
 * @param string $className 
 */
function __autoload( $className )
{
    ezcBase::autoload( $className );
}

// Central creation and configuration of the caches
// The ezcCacheManager just stores the configuration right now and 
// performs sanity checks. The {@link ezcCacheStorage} instances
// will be created on demand, when you use them for the first time

// Configuration options for a cache {@link ezcCacheStorage}
$options = array(
    'ttl'   => 60*60*24*2,     // Default would be 1 day, here 2 days
);

// Create a cache named "content", that resides in /var/cache/content
// The cache instance will use the {@link ezcCacheStorageFileArray} class
// to store the cache data. The time-to-live for cache items is set as 
// defined above.
ezcCacheManager::createCache( 'content', $basePath.'/content', 'ezcCacheStorageFileArray', $options );

// Create another cache, called "template" in /var/cache/templates.
// This cache will use the {@link ezcCacheStorageFilePlain} class to store
// cache data. It has the same TTL as the cache defined above.
ezcCacheManager::createCache( 'template', $basePath.'/templates', 'ezcCacheStorageFilePlain', $options );

// Somewhere in the application you can access the caches
 
// Get the instance of the cache called "content"
// Now the instance of {@link ezcCacheStorageFileArray is created and
// returned to be used. Next time you access this cache, the created
// instance will be reused.
$cache = ezcCacheManager::getCache( 'content' );

// Specify any number of attributes to identify the cache item you want
// to store. This attributes can be used later to perform operations
// on a set of cache items, that share a common attribute.
$attributes = array( 'node' => 2, 'area' => 'admin', 'lang' => 'en-GB' );
// This function is not part of the Cache package. You have to define
// unique IDs for your cache items yourself.
$id = getUniqueId();

// Initialize the data variable you want to restore
$data = '';
// Check if data is available in the cache. The restore method returns
// the cached data, if available, or bool false.
if ( ( $data = $cache->restore( $id, $attributes ) ) === false )
{
   // The cache item we tried to restore does not exist, so we have to
   // generate the data.
   $data = array( 'This is some data', 'and some more data.' );
   // For testing we echo something here...
   echo "No cache data found. Generated some.\n".var_export( $data, true )."\n";
   // Now we store the data in the cache. It will be available through 
   // restore, next time the code is reached
   $cache->store( $id, $data, $attributes );
}
else
{
    // We found cache data. Let's echo the information.
   echo "Cache data found.\n".var_export( $data, true )."\n";
}

// In some other place you can access the second defined cache.
$cache = ezcCacheManager::getCache( 'template' );

// Here we are removing cache items. We do not specify an ID (which would
// have meant to delete 1 specific cache item), but only an array of 
// attributes. This will result in all cache items to be deleted, that
// have this attribute assigned.
$cache->delete( null, array( 'node' => 5 ) );
?>
