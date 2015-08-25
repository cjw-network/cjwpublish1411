<?php
/**
 * File containing the eZExecution class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZExecution ezexecution.php
  \brief Handles proper script execution, fatal error detection and handling.

  By registering a fatal error handler it's possible for the PHP script to
  catch fatal errors, such as "Call to a member function on a non-object".

  By registering a cleanup handler it's possible to make sure the script can
  end properly.
*/

class eZExecution
{
    /*!
     Sets the clean exit flag to on,
     this notifies the exit handler that everything finished properly.
    */
    static function setCleanExit( $hasCleanExit = true )
    {
        self::$hasCleanExit = $hasCleanExit;
    }

    /*!
     Calls the cleanup handlers to make sure that the script is ready to exit.
    */
    static function cleanup()
    {
        $handlers = eZExecution::cleanupHandlers();
        foreach ( $handlers as $handler )
        {
            if ( is_callable( $handler ) )
                call_user_func( $handler );
            else
                eZDebug::writeError('Could not call cleanup handler, is it a static public function?', __METHOD__ );
        }
    }

    /*!
     Adds a cleanup handler to the end of the list,
     \a $handler must contain the name of the function to call.
     The function is called at the end of the script execution to
     do some cleanups.
    */
    static function addCleanupHandler( $handler )
    {
        self::registerShutdownHandler();
        self::$cleanupHandlers[] = $handler;
    }

    /*!
     \return An array with cleanup handlers.
    */
    static function cleanupHandlers()
    {
        return self::$cleanupHandlers;
    }

    /*!
     Adds a fatal error handler to the end of the list,
     \a $handler must contain the name of the function to call.
     The handler will be called whenever a fatal error occurs,
     which usually happens when the script did not finish.
    */
    static function addFatalErrorHandler( $handler )
    {
        self::registerShutdownHandler();
        self::$fatalErrorHandlers[] = $handler;
    }

    /*!
     \return An array with fatal error handlers.
    */
    static function fatalErrorHandlers()
    {
        return self::$fatalErrorHandlers;
    }

    /*!
     \return true if the request finished properly.
    */
    static function isCleanExit()
    {
        return self::$hasCleanExit;
    }

    /*!
     Sets the clean exit flag and exits the page.
     Use this if you want premature exits instead of the \c exit function.
    */
    static function cleanExit()
    {
        eZExecution::cleanup();
        eZExecution::setCleanExit();
        exit;
    }

    /*!
     Exit handler which called after the script is done, if it detects
     that eZ Publish did not exit cleanly it will issue an error message
     and display the debug.
    */
    static function uncleanShutdownHandler()
    {
        // Need to change the current directory, since this information is lost
        // when the callbackfunction is called. eZDocumentRoot is set in ::registerShutdownHandler
        // Getting the previous current working directory as we might need to get back there (i.e. Symfony web/ directory).
        $previousCwd = getcwd();
        if ( self::$eZDocumentRoot !== null )
        {
            chdir( self::$eZDocumentRoot );
        }

        if ( eZExecution::isCleanExit() )
        {
            chdir( $previousCwd );
            return;
        }

        eZExecution::cleanup();
        $handlers = eZExecution::fatalErrorHandlers();
        foreach ( $handlers as $handler )
        {
            if ( is_callable( $handler ) )
                call_user_func( $handler );
            else

                eZDebug::writeError('Could not call fatal error handler, is it a static public function?', __METHOD__ );
        }

        chdir( $previousCwd );
    }

    /*!
     Register ::uncleanShutdownHandler as shutdown function
    */
    static public function registerShutdownHandler( $documentRoot = false )
    {
        if ( !self::$shutdownHandle )
        {
            register_shutdown_function( array('eZExecution', 'uncleanShutdownHandler') );
            /*
                see:
                - http://www.php.net/manual/en/function.session-set-save-handler.php
                - http://bugs.php.net/bug.php?id=33635
                - http://bugs.php.net/bug.php?id=33772
            */
            register_shutdown_function( array('eZSession', 'stop') );
            set_exception_handler( array('eZExecution', 'defaultExceptionHandler') );
            self::$shutdownHandle = true;
        }

        // Needed by the error handler, since the current directory is lost when
        // the callback function eZExecution::uncleanShutdownHandler is called.
        if ( $documentRoot )
        {
            self::$eZDocumentRoot = $documentRoot;
        }
        else if ( self::$eZDocumentRoot === null )
        {
            self::$eZDocumentRoot = getcwd();
        }
    }

    /**
     * Installs the default Exception handler
     *
     * @params Exception the exception
     * @return void
     */
    static public function defaultExceptionHandler( Exception $e )
    {
        if( PHP_SAPI != 'cli' )
        {
            header( 'HTTP/1.x 500 Internal Server Error' );
            header( 'Content-Type: text/html' );

            echo "An unexpected error has occurred. Please contact the webmaster.<br />";

            if( eZDebug::isDebugEnabled() )
            {
                echo $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine();
            }
        }
        else
        {
            $cli = eZCLI::instance();
            $cli->error( "An unexpected error has occurred. Please contact the webmaster.");

            if( eZDebug::isDebugEnabled() )
            {
                $cli->error( $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine() );
            }
        }

        eZLog::write( 'Unexpected error, the message was : ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine(), 'error.log' );

        eZExecution::cleanup();
        eZExecution::setCleanExit();
        exit( 1 );
    }

    static private $eZDocumentRoot = null;
    static private $hasCleanExit = false;
    static private $shutdownHandle = false;
    static private $fatalErrorHandlers = array();
    static private $cleanupHandlers = array();
}


?>
