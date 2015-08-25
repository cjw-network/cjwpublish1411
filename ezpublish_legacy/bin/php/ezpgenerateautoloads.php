#!/usr/bin/env php
<?php
/**
 * File containing the ezpgenerateautoloads.php script.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

if ( file_exists( "config.php" ) )
{
    require_once "config.php";
}

// Setup, includes
//{
$appName = defined( 'EZP_APP_FOLDER_NAME' ) ? EZP_APP_FOLDER_NAME : 'ezpublish';
$appFolder = getcwd() . "/../$appName";
$legacyVendorDir = getcwd() . "/vendor";

$baseEnabled = true;
// Bundled
if ( defined( 'EZP_USE_BUNDLED_COMPONENTS' ) ? EZP_USE_BUNDLED_COMPONENTS === true : file_exists( 'lib/ezc' ) )
{
    set_include_path( './lib/ezc' . PATH_SEPARATOR . get_include_path() );
    require 'Base/src/base.php';
}
// Custom config.php defined
else if ( defined( 'EZC_BASE_PATH' ) )
{
    require EZC_BASE_PATH;
}
// Composer if in eZ Publish5 context
else if ( strpos( $appFolder, "{$appName}/../{$appName}" ) === false && file_exists( "{$appFolder}/autoload.php" ) )
{
    require_once "{$appFolder}/autoload.php";
    $baseEnabled = false;
}
// Composer if in eZ Publish legacy context
else if ( file_exists( "{$legacyVendorDir}/autoload.php" ) )
{
    require_once "{$legacyVendorDir}/autoload.php";
    $baseEnabled = false;
}
// PEAR
else
{
    if ( !@include 'ezc/Base/base.php' )
    {
        require 'Base/src/base.php';
    }
}

if ( $baseEnabled )
{
    spl_autoload_register( array( 'ezcBase', 'autoload' ) );
}

require 'kernel/private/classes/ezautoloadgenerator.php';
require 'kernel/private/interfaces/ezpautoloadoutput.php';
require 'kernel/private/classes/ezpautoloadclioutput.php';
require 'kernel/private/options/ezpautoloadgeneratoroptions.php';
require 'kernel/private/structs/ezpautoloadfilefindcontext.php';

//}

// Setup console parameters
//{
$params = new ezcConsoleInput();

$helpOption = new ezcConsoleOption( 'h', 'help' );
$helpOption->mandatory = false;
$helpOption->shorthelp = "Show help information";
$params->registerOption( $helpOption );

$quietOption = new ezcConsoleOption( 'q', 'quiet', ezcConsoleInput::TYPE_NONE );
$quietOption->mandatory = false;
$quietOption->shorthelp = "do not give any output except when errors occur";
$params->registerOption( $quietOption );

$targetOption = new ezcConsoleOption( 't', 'target', ezcConsoleInput::TYPE_STRING );
$targetOption->mandatory = false;
$targetOption->shorthelp = "The directory to where the generated autoload file should be written.";
$params->registerOption( $targetOption );

$verboseOption = new ezcConsoleOption( 'v', 'verbose', ezcConsoleInput::TYPE_NONE );
$verboseOption->mandatory = false;
$verboseOption->shorthelp = "Whether or not to display more information.";
$params->registerOption( $verboseOption );

$dryrunOption = new ezcConsoleOption( 'n', 'dry-run', ezcConsoleInput::TYPE_NONE );
$dryrunOption->mandatory = false;
$dryrunOption->shorthelp = "Whether a new file autoload file should be written.";
$params->registerOption( $dryrunOption );

$kernelFilesOption = new ezcConsoleOption( 'k', 'kernel', ezcConsoleInput::TYPE_NONE );
$kernelFilesOption->mandatory = false;
$kernelFilesOption->shorthelp = "If an autoload array for the kernel files should be generated.";
$params->registerOption( $kernelFilesOption );

$kernelOverrideOption = new ezcConsoleOption( 'o', 'kernel-override', ezcConsoleInput::TYPE_NONE );
$kernelOverrideOption->mandatory = false;
$kernelOverrideOption->shorthelp = "If an autoload array for the kernel override files should be generated.";
$params->registerOption( $kernelOverrideOption );

$extensionFilesOption = new ezcConsoleOption( 'e', 'extension', ezcConsoleInput::TYPE_NONE );
$extensionFilesOption->mandatory = false;
$extensionFilesOption->shorthelp = "If an autoload array for the extensions should be generated.";
$params->registerOption( $extensionFilesOption );

$testFilesOption = new ezcConsoleOption( 's', 'tests', ezcConsoleInput::TYPE_NONE );
$testFilesOption->mandatory = false;
$testFilesOption->shorthelp = "If an autoload array for the tests should be generated.";
$params->registerOption( $testFilesOption );

$excludeDirsOption = new ezcConsoleOption( '', 'exclude', ezcConsoleInput::TYPE_STRING );
$excludeDirsOption->mandatory = false;
$excludeDirsOption->shorthelp = "Folders to exclude from the class search.";
$params->registerOption( $excludeDirsOption );

$displayProgressOption = new ezcConsoleOption( 'p', 'progress', ezcConsoleInput::TYPE_NONE );
$displayProgressOption->mandatory = false;
$displayProgressOption->shorthelp = "If progress output should be shown on the command-line.";
$params->registerOption( $displayProgressOption );

// Add an argument for which extension to search
$params->argumentDefinition = new ezcConsoleArguments();

$params->argumentDefinition[0] = new ezcConsoleArgument( 'extension' );
$params->argumentDefinition[0]->mandatory = false;
$params->argumentDefinition[0]->shorthelp = "Extension to generate autoload files for.";
$params->argumentDefinition[0]->default = getcwd();

// Process console parameters
try
{
    $params->process();
}
catch ( ezcConsoleOptionException $e )
{
    print( $e->getMessage(). "\n" );
    print( "\n" );

    echo $params->getHelpText( 'Autoload file generator.' ) . "\n";

    echo "\n";
    exit();
}

if ( $helpOption->value === true )
{
    echo $params->getHelpText( 'Autoload file generator.' ) . "\n";
    exit();
}
//}

if ( $excludeDirsOption->value !== false )
{
    $excludeDirs = explode( ',', $excludeDirsOption->value );
}
else
{
    $excludeDirs = array();
}

$autoloadOptions = new ezpAutoloadGeneratorOptions();

$autoloadOptions->basePath = $params->argumentDefinition['extension']->value;
$autoloadOptions->searchKernelFiles = $kernelFilesOption->value;
$autoloadOptions->searchKernelOverride = $kernelOverrideOption->value;
$autoloadOptions->searchExtensionFiles = $extensionFilesOption->value;
$autoloadOptions->searchTestFiles = $testFilesOption->value;
$autoloadOptions->writeFiles = !$dryrunOption->value;
$autoloadOptions->displayProgress = $displayProgressOption->value;

if ( !empty( $targetOption->value ) )
{
    $autoloadOptions->outputDir = $targetOption->value;
}
$autoloadOptions->excludeDirs = $excludeDirs;

$autoloadGenerator = new eZAutoloadGenerator( $autoloadOptions );

if ( defined( 'EZP_AUTOLOAD_OUTPUT' ) )
{
    $outputClass = EZP_AUTOLOAD_OUTPUT;
    $autoloadCliOutput = new $outputClass();
}
else
{
    $autoloadCliOutput = new ezpAutoloadCliOutput( $quietOption->value );
}

$autoloadGenerator->setOutputObject( $autoloadCliOutput );
$autoloadGenerator->setOutputCallback( array( $autoloadCliOutput, 'outputCli') );

try
{
    $autoloadGenerator->buildAutoloadArrays();

    // If we are showing progress output, let's print the list of warnings at
    // the end.
    if ( $displayProgressOption->value )
    {
        $warningMessages = $autoloadGenerator->getWarnings();
        foreach ( $warningMessages as $msg )
        {
            $autoloadCliOutput->outputCli( $msg, "warning" );
        }
    }

    if ( $verboseOption->value )
    {
        $autoloadGenerator->printAutoloadArray();
    }
}
catch (Exception $e)
{
    echo $e->getMessage() . "\n";
}

?>
