#!/usr/bin/env php
<?php
/**
 * File containing the checkdbfiles.php script.
 *
 * @deprecated and unmaintained since 5.0
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

require_once 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance( array( 'description' => ( "eZ Publish DB file verifier\n\n" .
                                                        "Checks the database update files and gives a report on them.\n" .
                                                        "It will show which files are missing and which should not be present.\n" .
                                                        "\n" .
                                                        "For each file with problems it will output a status and the filepath\n" .
                                                        "The status will be one of these:\n" .
                                                        " '?' file is not defined in upgrade path\n" .
                                                        " '!' file defined in upgrade path but missing on filesystem\n" .
                                                        " 'A' file is present in working copy but not in the original stable branch\n" .
                                                        " 'C' file data conflicts with the original stable branch\n" .
                                                        "\n" .
                                                        "Example output:\n" .
                                                        "  checkdbfiles.php\n" .
                                                        "  ? update/database/mysql/3.5/dbupdate-3.5.0-to-3.5.1.sql" ),
                                     'use-session' => false,
                                     'use-modules' => false,
                                     'use-extensions' => true ) );

$script->startup();

$options = $script->getOptions( "[no-verify-branches][export-path:]",
                                "",
                                array( 'no-verify-branches' => "Do not verify the content of the files with previous branches (To avoid SVN usage)",
                                       'export-path' => "Directory to use for doing SVN exports."
                                       ) );
$script->initialize();

$dbTypes = array();
$dbTypes[] = 'mysql';
$dbTypes[] = 'postgresql';

$branches = array();
$branches[] = '4.1';
$branches[] = '4.2';
$branches[] = '4.3';
$branches[] = '4.4';

// Controls the lowest version which will be exported and verified against current data
$lowestExportVersion = '4.3';

/********************************************************
*** NOTE: The following arrays do not follow the
***       coding standard, the reason for this is
***       to make it easy to merge any changes between
***       the various eZ Publish branches.
*********************************************************/

$versions = array();
$versions41 = array( 'unstable' => array(  array( '4.0.0',       '4.1.0alpha1' ),
                                           array( '4.1.0alpha1', '4.1.0alpha2' ),
                                           array( '4.1.0alpha2', '4.1.0beta1' ),
                                           array( '4.1.0beta1', '4.1.0rc1' ),
                                           array( '4.1.0rc1', '4.1.0' )
                                        ),
                     'unstable_subdir' => 'unstable',
                     'stable' => array( array( '4.0.0', '4.1.0' ) ) );
$versions42 = array( 'unstable' => array( array( '4.1.0',   '4.2.0alpha1' ),
                                          array( '4.2.0alpha1', '4.2.0beta1' ),
                                          array( '4.2.0beta1', '4.2.0rc1' ),
                                          array( '4.2.0rc1', '4.2.0rc2' ),
                                          array( '4.2.0rc2', '4.2.0' ),
                                        ),
                     'unstable_subdir' => 'unstable',
                     'stable' => array( array( '4.1.0', '4.2.0' ) )
                    );

$versions43 = array( 'unstable' => array( array( '4.2.0', '4.3.0alpha1' ),
                                          array( '4.3.0alpha1', '4.3.0beta1' ),
                                          array( '4.3.0beta1', '4.3.0beta2' ),
                                          array( '4.3.0beta2', '4.3.0rc1' ),
                                          array( '4.3.0rc1', '4.3.0' ),
                    ),
             'unstable_subdir' => 'unstable',
             'stable' => array( array( '4.2.0', '4.3.0' ) ),
           );

$versions44 = array( 'unstable' => array( array( '4.3.0', '4.4.0alpha1' ),
                                         array( '4.4.0alpha1', '4.4.0alpha2' ),
                                         array( '4.4.0alpha2', '4.4.0alpha3' ),
                                         array( '4.4.0alpha3', '4.4.0alpha4' ),
                                         array( '4.4.0alpha4', '4.4.0alpha5' ),
                                         array( '4.4.0alpha5', '4.4.0beta1' ),
                                         array( '4.4.0beta1', '4.4.0beta2' ),
                                         array( '4.4.0beta2', '4.4.0beta3' ),
                                         array( '4.4.0beta3', '4.4.0' ),

                    ),
             'unstable_subdir' => 'unstable',
             'stable' => array( array( '4.3.0', '4.4.0' ) ),
           );

$versions45 = array( 'unstable' => array( array( '4.4.0', '4.5.0alpha1' ),
                                          array( '4.5.0alpha1', '4.5.0beta1' ),
                                          array( '4.5.0beta1', '4.5.0beta2' ),
                                          array( '4.5.0beta2', '4.5.0' ),
                    ),
             'unstable_subdir' => 'unstable',
             'stable' => array( array( '4.4.0', '4.5.0' ) ),
           );

$versions46 = array( 'unstable' => array( array( '4.5.0', '4.6.0alpha1' ),
                                          array( '4.6.0alpha1', '4.6.0beta1' ),
                                          array( '4.6.0beta1', '4.6.0rc1' ),
                                          array( '4.6.0rc1', '4.6.0' ),
                    ),
             'unstable_subdir' => 'unstable',
             'stable' => array( array( '4.5.0', '4.6.0' ) ),
           );

$versions47 = array( 'unstable' => array( array( '4.6.0', '4.7.0alpha1' ),
                                          array( '4.7.0alpha1', '4.7.0beta1' ),
                                          array( '4.7.0beta1', '4.7.0rc1' ),
                                          array( '4.7.0rc1', '4.7.0' ),
                    ),
             'unstable_subdir' => 'unstable',
             'stable' => array( array( '4.6.0', '4.7.0' ) ),
           );

$versions50 = array( 'unstable' => array( array( '4.7.0', '5.0.0alpha1' ),
                                          array( '5.0.0alpha1', '5.0.0' ),
                    ),
             'unstable_subdir' => 'unstable',
             'stable' => array( array( '4.7.0', '5.0.0' ) ),
           );

// Note: DB updates are kept in base sql file regardless of state as of 5.1
$versions51 = array( 'unstable' => array( ),
             'unstable_subdir' => 'unstable',
             'stable' => array( array( '5.0.0', '5.1.0' ) ),
           );


$versions['4.1'] = $versions41;
$versions['4.2'] = $versions42;
$versions['4.3'] = $versions43;
$versions['4.4'] = $versions44;
$versions['4.5'] = $versions45;
$versions['4.6'] = $versions46;
$versions['4.7'] = $versions47;
$versions['5.0'] = $versions50;
$versions['5.1'] = $versions51;

$fileList = array();
$missingFileList = array();
$conflictFileList = array();
$exportMissingFileList = array();
$scannedDirs = array();

function handleVersionList( $basePath, $subdir,
                            &$fileList, &$missingFileList, &$conflictFileList, &$scannedDirs,
                            $useInfoFiles, $versionList )
{
    $updatePath = $basePath . $subdir;
    if ( is_dir( $updatePath ) )
    {
        if ( !in_array( $updatePath, $scannedDirs ) )
        {
            $dh = opendir( $updatePath );
            if ( $dh )
            {
                while ( ( $file = readdir( $dh ) ) !== false )
                {
                    if ( $file == '.' or
                         $file == '..' or
                         substr( $file, strlen( $file ) - 1, 1 ) == '~' or
                         is_dir( $updatePath . '/' . $file ) )
                        continue;
                    $fileList[] = $updatePath . '/' . $file;
                }
                closedir( $dh );
            }
            $fileList = array_unique( $fileList );
            $scannedDirs[] = $updatePath;
        }
    }

    foreach ( $versionList as $versionEntry )
    {
        $from = $versionEntry[0];
        $to = $versionEntry[1];
        $dir = $updatePath;
        $file = $dir . '/dbupdate-' . $from . '-to-' . $to . '.sql';
        $fileList = array_diff( $fileList, array( $file ) );
        if ( !file_exists( $file ) )
        {
            $missingFileList[] = $file;
        }
        if ( $useInfoFiles )
        {
            $infoFile = $dir . '/dbupdate-' . $from . '-to-' . $to . '.info';
            $fileList = array_diff( $fileList, array( $infoFile ) );
            if ( !file_exists( $infoFile ) )
            {
                $missingFileList[] = $infoFile;
            }
        }
    }
}

function handleExportVersionList( $basePath, $exportBasePath, $subdir,
                                  &$fileList, &$missingFileList, &$exportMissingFileList, &$conflictFileList, &$scannedDirs,
                                  $useInfoFiles, $versionList )
{
    $updatePath = $basePath . $subdir;
    $exportUpdatePath = $exportBasePath . $subdir;
    foreach ( $versionList as $versionEntry )
    {
        $from = $versionEntry[0];
        $to = $versionEntry[1];
        $file = $updatePath . '/dbupdate-' . $from . '-to-' . $to . '.sql';
        $exportFile = $exportUpdatePath . '/dbupdate-' . $from . '-to-' . $to . '.sql';
        if ( file_exists( $file ) and file_exists( $exportFile ) )
        {
            $srcMD5 = md5_file( $file );
            $dstMD5 = md5_file( $exportFile );
            // If the MD5s differ we flag it as a conflict
            if ( strcmp( $srcMD5, $dstMD5 ) != 0 )
            {
                $conflictFileList[] = $file;
            }
        }
        else
        {
            $exportMissingFileList[] = $file;
        }

        if ( $useInfoFiles )
        {
            $infoFile = $updatePath . '/dbupdate-' . $from . '-to-' . $to . '.info';
            $exportInfoFile = $exportUpdatePath . '/dbupdate-' . $from . '-to-' . $to . '.sql';
            if ( file_exists( $infoFile ) and file_exists( $exportInfoFile ) )
            {
                $srcMD5 = md5_file( $infoFile );
                $dstMD5 = md5_file( $exportInfoFile );
                // If the MD5s differ we flag it as a conflict
                if ( strcmp( $srcMD5, $dstMD5 ) != 0 )
                {
                    $conflictFileList[] = $file;
                }
            }
            else
            {
                $exportMissingFileList[] = $infoFile;
            }
        }
    }
}

function exportSVNVersion( $version, $exportPath )
{
    $versionPath = $exportPath . '/' . $version;
    if ( file_exists( $versionPath ) )
        return true;

    $svn = "svn export http://svn.ez.no/svn/ezpublish/stable/$version/update/database \"$versionPath\"";
    exec( $svn, $output, $code );
    if ( $code != 0 )
    {
        print( "Failed to export using:\n$svn\n" );
        return false;
    }
    return file_exists( $versionPath );
}

// Check for required md5_file function
if ( !function_exists( 'md5_file' ) )
{
    $cli->error( "The function 'md5_file' does not exist in your PHP version" );
    $cli->error( "You must upgrade PHP to a version (4.2.0) that has this function" );
    $script->shutdown( 1 );
}

if ( !$options['no-verify-branches'] )
{
    // Clean up the export path and/or recreate the directory path
    if ( $options['export-path'] )
    {
        $exportPath = $options['export-path'];
    }
    else
    {
        $exportPath = '/tmp/';
        if ( isset( $_SERVER['TMPDIR'] ) )
            $exportPath = $_SERVER['TMPDIR'] . '/';
        if ( isset( $_SERVER['USER'] ) )
            $exportPath .= "ez-" . $_SERVER['USER'];
        $exportPath .= "/dbupdate-check/";
    }

    if ( file_exists( $exportPath ) )
    {
        eZDir::recursiveDelete( $exportPath, false );
    }
    eZDir::mkdir( $exportPath, false, true );
}

// Figure out the current branch, we do not want to export it
$currentBranch = eZPublishSDK::VERSION_MAJOR . '.' . eZPublishSDK::VERSION_MINOR;

foreach ( $dbTypes as $dbType )
{
    foreach ( $branches as $branch )
    {
        $basePath = 'update/database/' . $dbType . '/' . $branch;
        $versionList = $versions[$branch];
        $useInfoFiles = false;
        if ( isset( $versionList['info_files'] ) )
        {
            $useInfoFiles = $versionList['info_files'];
        }
        if ( isset( $versionList['unstable'] ) )
        {
            $subdir = false;
            if ( isset( $versionList['unstable_subdir'] ) )
            {
                $subdir = '/' . $versionList['unstable_subdir'];
            }
            handleVersionList( $basePath, $subdir,
                               $fileList, $missingFileList, $conflictFileList, $scannedDirs,
                               $useInfoFiles, $versionList['unstable'] );
        }
        if ( isset( $versionList['stable'] ) )
        {
            $subdir = false;
            if ( isset( $versionList['stable_subdir'] ) )
            {
                $subdir = '/' . $versionList['stable_subdir'];
            }
            handleVersionList( $basePath, $subdir,
                               $fileList, $missingFileList, $conflictFileList, $scannedDirs,
                               $useInfoFiles, $versionList['stable'] );
        }

        if ( !$options['no-verify-branches'] and
             version_compare( $branch, $lowestExportVersion ) >= 0 and
             version_compare( $branch, $currentBranch ) < 0 )
        {
            if ( !exportSVNVersion( $branch, $exportPath ) )
            {
                $conflictFileList[] = $dir . '/' . $branch;
                continue;
            }
            if ( isset( $versionList['unstable'] ) )
            {
                $exportBasePath = $exportPath . '/' . $branch . '/' . $dbType . '/' . $branch;
                $subdir = false;
                if ( isset( $versionList['unstable_subdir'] ) )
                {
                    $subdir = '/' . $versionList['unstable_subdir'];
                }
                handleExportVersionList( $basePath, $exportBasePath, $subdir,
                                         $fileList, $missingFileList, $exportMissingFileList, $conflictFileList, $scannedDirs,
                                         $useInfoFiles, $versionList['unstable'] );
            }
            if ( isset( $versionList['stable'] ) )
            {
                $exportBasePath = $exportPath . '/' . $branch . '/' . $dbType . '/' . $branch;
                $subdir = false;
                if ( isset( $versionList['stable_subdir'] ) )
                {
                    $subdir = '/' . $versionList['stable_subdir'];
                }
                handleExportVersionList( $basePath, $exportBasePath, $subdir,
                                         $fileList, $missingFileList, $exportMissingFileList, $conflictFileList, $scannedDirs,
                                         $useInfoFiles, $versionList['stable'] );
            }
        }
    }
}

if ( count( $missingFileList ) > 0 or
     count( $exportMissingFileList ) > 0 or
     count( $fileList ) > 0 or
     count( $conflictFileList ) > 0 )
{
    if ( count( $fileList ) > 0 )
    {
        foreach ( $fileList as $file )
        {
            print( '? ' . $file . "\n" );
        }
    }

    if ( count( $missingFileList ) > 0 )
    {
        foreach ( $missingFileList as $file )
        {
            print( '! ' . $file . "\n" );
        }
    }

    if ( count( $exportMissingFileList ) > 0 )
    {
        foreach ( $exportMissingFileList as $file )
        {
            print( 'A ' . $file . "\n" );
        }
    }

    if ( count( $conflictFileList ) > 0 )
    {
        foreach ( $conflictFileList as $file )
        {
            print( 'C ' . $file . "\n" );
        }
    }
    $script->setExitCode( 1 );
}

if ( !$options['no-verify-branches'] )
{
    // Cleanup any exports
    if ( file_exists( $exportPath ) )
    {
        eZDir::recursiveDelete( $exportPath, false );
    }
}

$script->shutdown();

?>
