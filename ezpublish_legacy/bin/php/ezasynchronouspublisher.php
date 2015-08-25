#!/usr/bin/env php
<?php
/**
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package
 */


declare( ticks=1 );

require_once 'autoload.php';

$cli = eZCLI::instance();

$script = eZScript::instance( array( 'description' => "Processes the eZ Publish publishing queue",
                                     'use-session' => false,
                                     'use-modules' => true,
                                     'use-extensions' => true ) );
$script->startup();

// check required pcntl functions (ubuntu 11 disables them by default)
$pcntlFunctions = array( 'pcntl_fork', 'pcntl_signal', 'pcntl_waitpid', 'pcntl_wexitstatus' );
foreach( $pcntlFunctions as $pcntlFunction )
{
    if ( !function_exists( $pcntlFunction ) )
    {
        $cli->error( "The following pcntl (http://php.net/pcntl) function is disabled: $pcntlFunction" );
        $cli->error( "Required functions: " . implode( ', ', $pcntlFunctions ) );
        $script->shutdown( 1 );
    }
}

$options = $script->getOptions(
    // options definition
    "[n|daemon][p:|pid-file:]",
    // arguments definition
    "",
    // options documentation
    array( 'daemon' => 'Run in the background',
           'pid-file' => 'PID file' ) );
$sys = eZSys::instance();

$script->initialize();

if ( isset( $options['pid-file'] ) )
{
    $pidFile = $options['pid-file'];
}
else
{
    $siteINI = eZINI::instance( 'site.ini' );
    $varDir = $siteINI->variable( 'FileSettings', 'VarDir' );
    $pidFile = "$varDir/run/ezasynchronouspublisher.pid";
}

// check if run folder exists
$pidFileDirectory = dirname( $pidFile );
if ( !file_exists( $pidFileDirectory ) )
{
    if ( !mkdir( $pidFileDirectory ) )
    {
        $script->shutdown( 3, "Error creating PID file directory '$pidFileDirectory'" );
    }
}

// try opening the PID file. Exclusive mode will prevent the file from being opened if it exists
$pidFp = @fopen( $pidFile, 'x' );
if ( $pidFp === false )
{
    // failed on exclusive creation, see if the file is locked
    $pidFp = fopen( $pidFile, 'r' );

    // lock obtained: the owner process has died without removing the file
    if ( flock( $pidFp, LOCK_EX | LOCK_NB ) === false )
    {
        fclose( $pidFp );
        $script->shutdown( 2, "Another instance of the daemon is already running with the same pid file" );
    }
    else
    {
        $cli->output( "Unclean shutdown has occured, taking ownership of the PID file" );
    }
}
else
{
    flock( $pidFp, LOCK_EX | LOCK_NB );
}

// PID file IS locked after that point

/**
 * Signal handler for the daemon process
 * @param int $signo Signal number
 */
$daemonSignalHandler = function ( $signo ) use ( $pidFp, $pidFile )
{
    switch( $signo )
    {
        case SIGTERM:
        case SIGINT:
            flock( $pidFp, LOCK_UN );
            fclose( $pidFp );

            ezpContentPublishingQueueProcessor::terminate();
            @unlink( $pidFile );
            eZScript::instance()->shutdown( 0 );
            break;
    }
};
pcntl_signal( SIGTERM, $daemonSignalHandler );
pcntl_signal( SIGINT, $daemonSignalHandler );

if ( $options['daemon'] )
{
    // Trap signals that we expect to recieve
    pcntl_signal( SIGCHLD, 'childHandler' );
    pcntl_signal( SIGUSR1, 'childHandler' );
    pcntl_signal( SIGALRM, 'childHandler' );

    // close the PID file, and reopen it after forking
    fclose( $pidFp );

    eZClusterFileHandler::preFork();
    $pid = pcntl_fork();
    if ( $pid < 0 )
    {
        error_log( "unable to fork daemon" );
        $script->shutdown( 1, "unable to fork daemon" );
    }
    // If we got a good PID, then we can wait until the daemon tells us to terminate
    if ( $pid > 0 )
    {
        // Wait for confirmation from the child via SIGTERM or SIGCHLD, or
        // for two seconds to elapse (SIGALRM).  pause() should not return. */
        sleep( 10 );

        $script->shutdown( 1, "Failed spawning the daemon process" );
    }

    $pidFp = fopen( $pidFile, 'w' );
    flock( $pidFp, LOCK_EX | LOCK_NB );

    // At this point we are executing as the child process
    $parentProcessID = posix_getppid();

    /* Cancel certain signals */
    pcntl_signal( SIGCHLD, SIG_DFL ); // A child process dies
    pcntl_signal( SIGTSTP, SIG_IGN ); // Various TTY signals
    pcntl_signal( SIGTTOU, SIG_IGN );
    pcntl_signal( SIGTTIN, SIG_IGN );
    pcntl_signal( SIGHUP,  SIG_IGN ); // Ignore hangup signal

    $sid = posix_setsid();
    if ( $sid < 0 )
    {
        error_log( "unable to create a new session" );
        $script->shutdown( 1, 'unable to create a new session' );
    }

    pcntl_signal( SIGTERM, $daemonSignalHandler );

    $pid = getmypid();
    $cli->output( "Publishing daemon started. Process ID: $pid" );
    fputs( $pidFp, $pid );

    // stop output completely
    fclose( STDIN );
    fclose( STDOUT );
    fclose( STDERR );

    // terminate the parent
    posix_kill( $parentProcessID, SIGUSR1 );
}
else
{
    $cli->output( "Running in interactive mode. Hit ctrl-c to interrupt." );
}

if ( $options['daemon'] )
{
    $output = new ezpAsynchronousPublisherLogOutput();
}
else
{
    $output = new ezpAsynchronousPublisherCliOutput();
}

// actual daemon code
$processor = ezpContentPublishingQueueProcessor::instance();
$processor->setOutput( $output );
$processor->setSignalHandler( $daemonSignalHandler );
$processor->run();

eZScript::instance()->shutdown( 0 );

/**
 * Signal handler
 * @param int $signo Signal number
 */
function childHandler( $signo )
{
    switch( $signo )
    {
        case SIGALRM: eZScript::instance()->shutdown( 1 ); break;
        case SIGUSR1: eZScript::instance()->shutdown( 0 ); break;
        case SIGCHLD: eZScript::instance()->shutdown( 1 ); break;
    }
}
