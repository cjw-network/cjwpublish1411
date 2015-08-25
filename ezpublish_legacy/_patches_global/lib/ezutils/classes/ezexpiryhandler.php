<?php
/**
 * // ###JAC_PATCH_G_44_EZ_2014.11### separate var_log and var_cache project folders => expiry.php in global var/cache
 *
 * File containing the eZExpiryHandler class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/**
 * Keeps track of expiry keys and their timestamps
 * @class eZExpiryHandler ezexpiryhandler.php
 */
class eZExpiryHandler
{

    function eZExpiryHandler()
    {
        $this->Timestamps = array();
        $this->IsModified = false;

        // ###JAC_PATCH_G_44_EZ_2014.11### separate var_log and var_cache project folders => expiry.php in global var/cache
        if ( defined( 'JAC_PATCH_PUT_EXPIRY_TO_GLOBAL_DIR_VAR_CACHE' ) && JAC_PATCH_PUT_EXPIRY_TO_GLOBAL_DIR_VAR_CACHE === true )
        {
            // alle expiry.php files global speichern damit cache in ram kann
            // damit die expiry.php nach neustart erhalten bleibt damit die Bilder richtig neu berechnet werden
            // z.B. beim bilder löschen wird ein Verfallstimestamp in die expiry.php geschrieben,
            // wenn Bildcachedatum kleiner dann wird dieses neu berechnet
            $ini = eZINI::instance();
            $projectName = $ini->variable( 'DatabaseSettings', 'Database' );

            // ez1411
            $databasePrefix = false;
            if ( $ini->hasVariable( 'DatabaseSettings', 'DatabasePrefix' ) )
            {
                $databasePrefix = $ini->variable( 'DatabaseSettings', 'DatabasePrefix' );
            }

            // Wenn ez_legacy über ez5 stack aufgerufen wird, dann ist der db name injected und enthält den prefix der db
            // wenn direkt aufgerufen dann ist es nur der Projektname
            //  DB z.B. ez1411_test-project mit  mit Prefix anfängt dann den Prefix entfernen und wir haben den projektnamen
            if ( strpos( $projectName, $databasePrefix ) === 0 )
            {
                $projectName = substr( $projectName, strlen( $databasePrefix ) );
            }

            $this->CacheFile = eZClusterFileHandler::instance(  'var/cache/expiry_'. $projectName .'.php' );
        }
        else
        {
            $cacheDirectory = eZSys::cacheDirectory();
            $this->CacheFile = eZClusterFileHandler::instance( $cacheDirectory . '/' . 'expiry.php' );
        }
        $this->restore();
    }

    /**
     * Load the expiry timestamps from cache
     *
     * @return void
     */
    function restore()
    {
        $Timestamps = $this->CacheFile->processFile( array( $this, 'fetchData' ) );
        if ( $Timestamps === false )
        {
            $errMsg = 'Fatal error - could not restore expiry.php file.';
            eZDebug::writeError( $errMsg, __METHOD__ );
            trigger_error( $errMsg, E_USER_ERROR );
        }

        $this->Timestamps = $Timestamps;
        $this->IsModified = false;
    }

    /**
     * Includes the expiry file and extracts the $Timestamps variable from it.
     * @param string $path
     */
    static function fetchData( $path )
    {
        include( $path );
        return $Timestamps;
    }

    /**
     * Stores the current timestamps values to cache
     */
    function store()
    {
        if ( $this->IsModified )
        {
            $this->CacheFile->storeContents( "<?php\n\$Timestamps = " . var_export( $this->Timestamps, true ) . ";\n?>", 'expirycache', false, true );
            $this->IsModified = false;
        }
    }

    /**
     * Sets the expiry timestamp for a key
     *
     * @param string $name Expiry key
     * @param int    $value Expiry timestamp value
     */
    function setTimestamp( $name, $value )
    {
        $this->Timestamps[$name] = $value;
        $this->IsModified = true;
    }

    /**
     * Checks if an expiry timestamp exist
     *
     * @param string $name Expiry key name
     *
     * @return bool true if the timestamp exists, false otherwise
     */
    function hasTimestamp( $name )
    {
        return isset( $this->Timestamps[$name] );
    }

    /**
     * Returns the expiry timestamp for a key
     *
     * @param string $name Expiry key
     *
     * @return int|false The timestamp if it exists, false otherwise
     */
    function timestamp( $name )
    {
        if ( !isset( $this->Timestamps[$name] ) )
        {
            eZDebug::writeError( "Unknown expiry timestamp called '$name'", __METHOD__ );
            return false;
        }
        return $this->Timestamps[$name];
    }

    /**
     * Returns the expiry timestamp for a key, or a default value if it isn't set
     *
     * @param string $name Expiry key name
     * @param int $default Default value that will be returned if the key isn't set
     *
     * @return mixed The expiry timestamp, or $default
     */
    static function getTimestamp( $name, $default = false )
    {
        $handler = eZExpiryHandler::instance();
        if ( !isset( $handler->Timestamps[$name] ) )
        {
            return $default;
        }
        return $handler->Timestamps[$name];
    }

    /**
     * Returns a shared instance of the eZExpiryHandler class
     *
     * @return eZExpiryHandler
     */
    static function instance()
    {
        if ( !isset( $GLOBALS['eZExpiryHandlerInstance'] ) ||
             !( $GLOBALS['eZExpiryHandlerInstance'] instanceof eZExpiryHandler ) )
        {
            $GLOBALS['eZExpiryHandlerInstance'] = new eZExpiryHandler();
        }

        return $GLOBALS['eZExpiryHandlerInstance'];
    }

    /**
     * Checks if a shared instance of eZExpiryHandler exists
     *
     * @return bool true if an instance exists, false otherwise
     */
    static function hasInstance()
    {
        return isset( $GLOBALS['eZExpiryHandlerInstance'] ) && $GLOBALS['eZExpiryHandlerInstance'] instanceof eZExpiryHandler;
    }

    /**
     * Called at the end of execution and will store the data if it is modified.
     */
    static function shutdown()
    {
        if ( eZExpiryHandler::hasInstance() )
        {
            eZExpiryHandler::instance()->store();
        }
    }

    /**
     * Registers the shutdown function.
     * @see eZExpiryHandler::shutdown()
     * @deprecated See EZP-22749
     */
    public static function registerShutdownFunction(){
        eZDebug::writeStrict( __METHOD__ . " is deprecated. See EZP-22749.", __METHOD__ . " is deprecated" );
    }

    /**
     * Holds the expiry timestamps array
     * @var array
     */
    public $Timestamps;

    /**
     * Wether data has been modified or not
     * @var bool
     */
    public $IsModified;
}

?>
