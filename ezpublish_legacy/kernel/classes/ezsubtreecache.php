<?php
/**
 * File containing the eZSubtreeCache class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZSubtreeCache ezsubtreecache.php
  \brief The class eZSubtreeCache does

*/

class eZSubtreeCache
{
    /*!
     Constructor
    */
    function eZSubtreeCache()
    {
    }

    /*!
     \static
     Removes caches which were created using 'cache-block' operator with 'subtree_expiry' parameter.
     \a $nodeList is an array of node's ids. It is used to determine caches to remove.
     if $nodeList is not an array or if $nodeList is empty all 'subtree_expiry' caches will be removed.
    */
    static function cleanupByNodeIDs( &$nodeIDList )
    {
        if ( !is_array( $nodeIDList ) || count( $nodeIDList ) === 0 )
        {
            eZSubtreeCache::cleanupAll();
        }
        else
        {
            $nodeList = eZContentObjectTreeNode::fetch( $nodeIDList );
            if ( $nodeList )
            {
                if ( !is_array( $nodeList ) )
                    $nodeList = array( $nodeList );

                eZSubtreeCache::cleanup( $nodeList );
            }
        }
    }

    /*!
     \static
     Clears template block caches with 'subtree_ezpiry' parameter for nodes in the $nodeList.
     Note: if 'DelayedCacheBlockCleanup' setting is enabled then expiried caches will be renamed only
     (removing from disk should be made, for example, by cronjob).
    */
    static function cleanup( &$nodeList )
    {
        if ( !is_array( $nodeList ) )
            return;

        $cacheDir = eZTemplateCacheBlock::templateBlockCacheDir();

        foreach ( $nodeList as $node )
        {
            $pathString = $node->attribute( 'path_string' );
            $pathString = trim( $pathString, '/' );
            $nodeListID = explode( '/', $pathString );

            foreach( $nodeListID as $nodeID )
            {
                $cachePath = $cacheDir . eZTemplateCacheBlock::subtreeCacheSubDirForNode( $nodeID );
                eZSubtreeCache::cleanupCacheDir( $cachePath );
            }
        }
    }

    /*!
     \static
     Removes all caches which were created using 'cache-block' operator with 'subtree_expiry' parameter.
    */
    static function cleanupAll()
    {
        $subtreeCacheDir = eZTemplateCacheBlock::templateBlockCacheDir() . eZTemplateCacheBlock::subtreeCacheBaseSubDir();
        eZSubtreeCache::cleanupCacheDir( $subtreeCacheDir );
    }

    /*!
     \static
     If DelayedCacheBlockCleanup is enables just renames $cachDir, otherwise removes $cacheDir from disk.
    */
    static function cleanupCacheDir( $cacheDir )
    {
        $ini = eZINI::instance();
        if ( $ini->variable( 'TemplateSettings', 'DelayedCacheBlockCleanup' ) === 'enabled' )
        {
            eZSubtreeCache::renameDir( $cacheDir );
        }
        else
        {
            eZSubtreeCache::removeExpiryCacheFromDisk( $cacheDir );
        }
    }

    /*!
     \static
     $dir is a path to the cache directory which should be renamed.
     $dir is relative to the root directiry of 'subtree' cache.
    */
    static function renameDir( $dir )
    {
        // just rename. Actual removing will be performed by cronjob.

        // This directory renaming is only performed on the local filesystem
        // to ensure purging of really old data. If the DB file handler is in
        // use it will check the modified_subnode field of the tree structure
        // to determin expiry when the cache-block entry is accessed.
        if ( file_exists( $dir ) )
        {
            if ( is_dir( $dir ) )
            {
                $uniqid = md5( uniqid( 'ezpsubtreecache'. getmypid(), true ) );
                $expiryCacheDir = eZSys::cacheDirectory() . '/template-block-expiry/' . $uniqid[0] . '/' . $uniqid[1] . '/' . $uniqid[2] . '/' . $uniqid;

                if ( !file_exists( $expiryCacheDir ) )
                {
                    eZDir::mkdir( $expiryCacheDir, false, true );
                }
                eZFile::rename( $dir, $expiryCacheDir, false, eZFile::APPEND_DEBUG_ON_FAILURE );
            }
            else
            {
                eZDebug::writeWarning( "$dir should be a directory. Template-block caches for 'subtree_expiry' are not removed.", __METHOD__ );
            }
        }
    }

    /*!
     \static
    */
    static function removeAllExpiryCacheFromDisk()
    {
        eZSubtreeCache::removeExpiryCacheFromDisk( eZSys::cacheDirectory() . '/template-block-expiry' );
    }

    /*!
     \static
     $expiryCachePath is a path to directory with cache that should be removed
    */
    static function removeExpiryCacheFromDisk( $expiryCachePath )
    {
        $fileHandler = eZClusterFileHandler::instance();
        if ( $fileHandler instanceof eZFSFileHandler )
        {
            // We will only delete files if the FS file handler is used,
            // if the DB file handler is in use the system will
            // instead use the modified_subnode field from the tree structure
            // in the database to determine if the cache is expired.
            // This reduces the need to perform expensive modifications to the
            // database entries for the cluster storage.
            $fileHandler->fileDelete( $expiryCachePath );
        }
    }
}

?>
