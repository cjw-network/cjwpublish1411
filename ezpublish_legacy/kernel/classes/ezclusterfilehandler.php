<?php
/**
 * File containing the eZClusterFileHandler class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */
class eZClusterFileHandler
{
    /**
     * Returns the configured instance of an eZClusterFileHandlerInterface
     * See ClusteringSettings.FileHandler in file.ini
     *
     * @param string|bool $filename
     *        Optional filename the handler should be initialized with
     *
     * @return eZClusterFileHandlerInterface
     */
    static function instance( $filename = false )
    {
        if ( self::$isShutdownFunctionRegistered !== true )
        {
            eZExecution::addCleanupHandler( array( __CLASS__, 'cleanupGeneratingFiles' ) );
            self::$isShutdownFunctionRegistered = true;
        }

        if( $filename !== false )
        {
            $optionArray = array( 'iniFile'      => 'file.ini',
                                  'iniSection'   => 'ClusteringSettings',
                                  'iniVariable'  => 'FileHandler',
                                  'handlerParams'=> array( $filename ) );

            $options = new ezpExtensionOptions( $optionArray );

            $handler = eZExtension::getHandlerClass( $options );

            return $handler;
        }
        else
        {
            // return Filehandler from GLOBALS based on ini setting.
            if ( self::$globalHandler === null )
            {
                $optionArray = array( 'iniFile'      => 'file.ini',
                                      'iniSection'   => 'ClusteringSettings',
                                      'iniVariable'  => 'FileHandler' );

                $options = new ezpExtensionOptions( $optionArray );

                $handler = eZExtension::getHandlerClass( $options );

                self::$globalHandler = $handler;
            }
            else
                $handler = self::$globalHandler;

            return $handler;
        }
    }

    /**
      * Resets the handler so that a new one can be loaded
      */
    public static function resetHandler()
    {
        self::cleanupGeneratingFiles();
        self::$globalHandler = null;
    }

    /**
     * Cluster shutdown handler. Terminates generation for unterminated files.
     * This situation doesn't happen by default, but may with custom code that doesn't follow recommendations.
     */
    static function cleanupGeneratingFiles()
    {
        if ( count( self::$generatingFiles ) === 0 )
        {
            return false;
        }
        else
        {
            eZDebug::writeWarning( "Execution was stopped while one or more files were generating. This should not happen.", __METHOD__ );
            foreach( self::$generatingFiles as $generatingFile )
            {
                $generatingFile->abortCacheGeneration();
                self::removeGeneratingFile( $generatingFile );
            }
            return true;
        }
    }

    /**
     * Goes trough the directory path and removes empty directories, starting at
     * the leaf and deleting down until a non empty directory is reached.
     * If the path is not a directory, nothing will happen.
     *
     * @param string $path
     */
    public static function cleanupEmptyDirectories( $path )
    {
        $dirpath = eZDir::dirpath( $path );

        eZDebugSetting::writeDebug( 'kernel-clustering', "eZClusterFileHandler::cleanupEmptyDirectories( '{$dirpath}' )" );

        if ( is_dir( $dirpath ) )
        {
            eZDir::cleanupEmptyDirectories( $dirpath );
        }
    }

    /**
     * Adds a file to the generating list
     *
     * @param eZDFSFileHandler|eZDFSFileHandler $file
     *        Cluster file handler instance
     *        Note that this method expect a version of the handler where the filePath is the REAL one, not the .generating
     */
    public static function addGeneratingFile( $file )
    {
        if ( !( $file instanceof eZDFSFileHandler ) )
            return false; // @todo Exception

        self::$generatingFiles[$file->filePath] = $file;
    }

    /**
     * Removes a file from the generating list
     * @param eZDFSFileHandler $file
     *        Cluster file handler instance
     *        Note that this method expect a version of the handler where the filePath is the REAL one, not the .generating
     *
     * @todo Clustering: apply the eZClusterFileHandlerInterface to all cluster handlers
     */
    public static function removeGeneratingFile( $file )
    {
        if ( !( $file instanceof eZDFSFileHandler ) )
            return false; // @todo Exception

        if ( isset( self::$generatingFiles[$file->filePath] ) )
            unset( self::$generatingFiles[$file->filePath] );
    }

    /**
     * Performs required operations before forking a process
     *
     * - disconnects DB based cluster handlers from the database
     */
    public static function preFork()
    {
        $clusterHandler = self::instance();

        // disconnect DB based cluster handlers from the database
        if ( $clusterHandler instanceof ezpDatabaseBasedClusterFileHandler )
        {
            $clusterHandler->disconnect();

            // destroy the current handler so that it reconnects when instanciated again
            self::$globalHandler = null;
        }
    }

    /**
     * Global list of currently generating files. Used by handlers that support stalecache.
     * @var array(filename => eZClusterFileHandlerInterface)
     */
    private static $generatingFiles = array();

    /**
     * Shutdown registration check variable
     * @var bool
     */
    private static $isShutdownFunctionRegistered = false;

    /**
     * Global, generic (e.g. not linked to a file) cluster handler, used for caching
     * @var eZClusterFileHandlerInterface
     */
    public static $globalHandler;
}

?>
