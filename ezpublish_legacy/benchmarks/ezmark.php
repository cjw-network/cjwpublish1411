#!/usr/bin/env php
<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$cli = eZCLI::instance();
$script = eZScript::instance( array( 'debug-message' => '',
                                      'use-session' => true,
                                      'use-modules' => true,
                                      'use-extensions' => true ) );

$script->startup();

$endl = $cli->endlineString();
$webOutput = $cli->isWebOutput();

function help()
{
    $argv = $_SERVER['argv'];
    $cli = eZCLI::instance();
    $cli->output( "Usage: " . $argv[0] . " [OPTION]... MARK [MARK]\n" .
                  "Runs selected benchmarks.\n" .
                  "e.g. " . $argv[0] . " eztemplate\n" .
                  "\n" .
                  "General options:\n" .
                  "  -h,--help          display this help and exit \n" .
                  "  -q,--quiet         do not give any output except when errors occur\n" .
                  "  -s,--siteaccess    selected siteaccess for operations, if not specified default siteaccess is used\n" .
                  "  -d,--debug         display debug output at end of execution\n" .
                  "  -c,--colors        display output using ANSI colors (default)\n" .
                  "  --sql              display sql queries\n" .
                  "  --logfiles         create log files\n" .
                  "  --no-logfiles      do not create log files (default)\n" .
                  "  --no-colors        do not use ANSI coloring\n" );
}

function changeSiteAccessSetting( &$siteaccess, $optionData )
{
    $cli = eZCLI::instance();
    if ( file_exists( 'settings/siteaccess/' . $optionData ) )
    {
        $siteaccess = $optionData;
        $cli->output( "Using siteaccess $siteaccess for cronjob" );
    }
    else
    {
        $cli->notice( "Siteaccess $optionData does not exist, using default siteaccess" );
    }
}

$siteaccess = false;
$debugOutput = false;
$allowedDebugLevels = false;
$useDebugAccumulators = false;
$useDebugTimingpoints = false;
$useIncludeFiles = false;
$useColors = true;
$isQuiet = false;
$useLogFiles = false;
$showSQL = false;
$markList = array();

$optionsWithData = array( 's' );
$longOptionsWithData = array( 'siteaccess' );

$readOptions = true;

for ( $i = 1; $i < count( $argv ); ++$i )
{
    $arg = $argv[$i];
    if ( $readOptions and
         strlen( $arg ) > 0 and
         $arg[0] == '-' )
    {
        if ( strlen( $arg ) > 1 and
             $arg[1] == '-' )
        {
            $flag = substr( $arg, 2 );
            if ( in_array( $flag, $longOptionsWithData ) )
            {
                $optionData = $argv[$i+1];
                ++$i;
            }
            if ( $flag == 'help' )
            {
                help();
                exit( 1 );
            }
            else if ( $flag == 'siteaccess' )
            {
                changeSiteAccessSetting( $siteaccess, $optionData );
            }
            else if ( $flag == 'debug' )
            {
                $debugOutput = true;
            }
            else if ( $flag == 'quiet' )
            {
                $isQuiet = true;
            }
            else if ( $flag == 'colors' )
            {
                $useColors = true;
            }
            else if ( $flag == 'no-colors' )
            {
                $useColors = false;
            }
            else if ( $flag == 'no-logfiles' )
            {
                $useLogFiles = false;
            }
            else if ( $flag == 'logfiles' )
            {
                $useLogFiles = true;
            }
            else if ( $flag == 'sql' )
            {
                $showSQL = true;
            }
        }
        else
        {
            $flag = substr( $arg, 1, 1 );
            $optionData = false;
            if ( in_array( $flag, $optionsWithData ) )
            {
                if ( strlen( $arg ) > 2 )
                {
                    $optionData = substr( $arg, 2 );
                }
                else
                {
                    $optionData = $argv[$i+1];
                    ++$i;
                }
            }
            if ( $flag == 'h' )
            {
                help();
                exit( 1 );
            }
            else if ( $flag == 'q' )
            {
                $isQuiet = true;
            }
            else if ( $flag == 'c' )
            {
                $useColors = true;
            }
            else if ( $flag == 'd' )
            {
                $debugOutput = true;
                if ( strlen( $arg ) > 2 )
                {
                    $levels = explode( ',', substr( $arg, 2 ) );
                    $allowedDebugLevels = array();
                    foreach ( $levels as $level )
                    {
                        if ( $level == 'all' )
                        {
                            $useDebugAccumulators = true;
                            $allowedDebugLevels = false;
                            $useDebugTimingpoints = true;
                            break;
                        }
                        if ( $level == 'accumulator' )
                        {
                            $useDebugAccumulators = true;
                            continue;
                        }
                        if ( $level == 'timing' )
                        {
                            $useDebugTimingpoints = true;
                            continue;
                        }
                        if ( $level == 'include' )
                        {
                            $useIncludeFiles = true;
                        }
                        if ( $level == 'error' )
                            $level = eZDebug::LEVEL_ERROR;
                        else if ( $level == 'warning' )
                            $level = eZDebug::LEVEL_WARNING;
                        else if ( $level == 'debug' )
                            $level = eZDebug::LEVEL_DEBUG;
                        else if ( $level == 'notice' )
                            $level = eZDebug::LEVEL_NOTICE;
                        else if ( $level == 'timing' )
                            $level = eZDebug::LEVEL_TIMING_POINT;
                        $allowedDebugLevels[] = $level;
                    }
                }
            }
            else if ( $flag == 's' )
            {
                changeSiteAccessSetting( $siteaccess, $optionData );
            }
        }
    }
    else
    {
        $markList[] = $arg;
    }
}

if ( count( $markList ) == 0 )
{
    help();
    $script->shutdown( 1 );
}

$script->setUseDebugOutput( $debugOutput );
$script->setAllowedDebugLevels( $allowedDebugLevels );
$script->setUseDebugAccumulators( $useDebugAccumulators );
$script->setUseDebugTimingPoints( $useDebugTimingpoints );
$script->setUseIncludeFiles( $useIncludeFiles );
$script->setIsQuiet( $isQuiet );

if ( $webOutput )
    $useColors = true;

$cli->setUseStyles( $useColors );
$script->setDebugMessage( "\n\n" . str_repeat( '#', 36 ) . $cli->style( 'emphasize' ) . " DEBUG " . $cli->style( 'emphasize-end' )  . str_repeat( '#', 36 ) . "\n" );

$script->setUseSiteAccess( $siteaccess );

$script->initialize();

$success = true;

foreach ( $markList as $markName )
{
    $markPath = 'benchmarks/' . $markName;
    $markDefinitionPath = $markPath . '/benchmark.php';
    if ( file_exists( $markDefinitionPath ) )
    {
        unset( $MarkDefinition );
        include( $markDefinitionPath );
        if ( isset( $MarkDefinition ) )
        {
            $mark = new eZBenchmark( $MarkDefinition['name'] );
            foreach ( $MarkDefinition['marks'] as $markDefinition )
            {
                $markTestFile = $markDefinition['file'];
                $markTestPath = $markPath . '/' . $markTestFile;
                if ( file_exists( $markTestPath ) )
                {
                    include_once( $markTestPath );
                    $markTestClass = $markDefinition['class'];
                    $markTestName = $markDefinition['name'];
                    if ( class_exists( $markTestClass ) )
                    {
                        $markTest = new $markTestClass( $markTestName );
                        $mark->addMark( $markTest );
                    }
                    else
                    {
                        $cli->warning( "Could not find test benchmark class '" . $cli->stylize( $markTestClass ) . "' for benchmark " .
                                       $cli->stylize( 'emphasize', $markTestName ) );
                    }
                }
                else
                {
                    $cli->warning( "Could not find a test benchmark file '" . $cli->stylize( $testUnitFile ) . "' for benchmark " .
                                   $cli->stylize( 'emphasize', $markName ) );
                }
            }
            $cli->output( "Benchmark results from mark " . $cli->stylize( 'emphasize', $markName ) );
            $runner = new eZBenchmarkCLIRunner();
            $runner->run( $mark, true );

        }
        else
        {
            $cli->warning( "Could not find a benchmark definition for benchmark " .
                           $cli->stylize( 'emphasize', $markName ) . "\n" .
                           $cli->stylize( 'emphasize', "\$MarkDefinition" ) . " is missing" );
        }
    }
    else
    {
        $cli->warning( "Could not find a benchmark definition for benchmark " . $cli->stylize( 'emphasize', $markName ) . "\nTried $markDefinitionPath" );
    }
}

$exitStatus = 0;
// if ( !$success )
// {
//     $cli->output();
//     $cli->output( "Some tests failed" );
//     $exitStatus = 1;
// }

$script->shutdown( $exitStatus );

?>
