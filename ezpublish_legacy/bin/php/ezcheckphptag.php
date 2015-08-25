#!/usr/bin/env php
<?php
/**
 * File containing the ezcheckphptag.php script.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

require_once 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance( array( 'description' => ( "eZ Publish PHP tag checker\n\n" .
                                                         "Checks for characters before the PHP start tag and after the PHP end tag\n" .
                                                         "and sets exit code based on the result\n" .
                                                         "PATH can either be a file or a directory\n" .
                                                         "\n" .
                                                         "ezcheckphptag.php lib" ),
                                      'use-session' => false,
                                      'use-modules' => true,
                                      'use-extensions' => true ) );

$script->startup();

$options = $script->getOptions( "[no-print]",
                                "[path+]",
                                array( 'no-print' => "Do not print path for bad files"
                                       ) );
$script->initialize();

if ( count( $options['arguments'] ) < 1 )
{
    $script->shutdown( 1, "No files to check" );
}

$print = true;
if ( $options['no-print'] )
    $print = false;

$ini = eZINI::instance();

$pathList = $options['arguments'];
$error = false;
$badFiles = array();

$shellTag = '#!';
$startTag = '<?php';
$shortStartTag = '<?';
$endTag = '?>';
$endNewlineTag = "?>\n";

foreach ( $pathList as $path )
{
    $files = array();
    if ( is_dir( $path ) )
    {
        $files = eZDir::recursiveFindRelative( false, $path, '.php' );
    }
    else if ( is_file( $path ) )
    {
        $files[] = $path;
    }
    else if ( !file_exists( $path ) )
    {
        if ( $print )
        {
            $cli->output( $cli->stylize( 'file', $path ) . ": file does not exist" );
        }
    }
    foreach ( $files as $file )
    {
        $fd = fopen( $file, 'r' );
        if ( $fd )
        {
            $startText = fread( $fd, 5 );
            $hasCorrectStart = false;
            $hasCorrectEnd = false;
            $errorText = array();
            if ( substr( $startText, 0, 2 ) == $shellTag )
            {
                $hasCorrectStart = true;
            }
            else if ( $startText == $startTag )
            {
                $hasCorrectStart = true;
            }
            else if ( substr( $startText, 0, 2 ) == $shortStartTag )
            {
                $errorText[] = "short start tag used";
            }
            else
            {
                $errorText[] = "does not start with PHP tag";
            }
            fseek( $fd, filesize( $file ) - 4, SEEK_SET );
            $endText = fread( $fd, 4 );
            $endText = preg_replace( "/\r\n|\r|\n/", "\n", $endText );
            $endText = substr( $endText, strlen( $endText ) - 3, 3 );
            if ( substr( $endText, 1 ) == $endTag or $endText == $endNewlineTag )
            {
                $hasCorrectEnd = true;
            }
            else
            {
                $errorText[] = "does not end with PHP tag";
            }
            fclose( $fd );
            if ( !$hasCorrectStart or !$hasCorrectEnd )
            {
                if ( $print )
                {
                    $text = $cli->stylize( 'file', $file );
                    if ( count( $errorText ) > 0 )
                        $text .= ": " . implode( ", ", $errorText );
                    $cli->output( $text );
                }
                $badFiles[] = $file;
            }
        }
        else
        {
            if ( $print )
                $cli->output( $cli->stylize( 'file', $file ) . ": could not open file" );
            $error = true;
        }
    }
}

if ( count( $badFiles ) > 0 or $error )
    $script->setExitCode( 1 );

$script->shutdown();

?>
