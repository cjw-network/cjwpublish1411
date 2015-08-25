#!/usr/bin/env php
<?php
/**
 * File containing the ezsqldumpisbndata.php script.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

require_once 'autoload.php';

$fileNameDba = 'db_data.dba';
$fileNameSql = 'cleandata.sql';
$stdOutSQL = null;
$stdOutDBA = null;

$cli = eZCLI::instance();
$script = eZScript::instance( array( 'description' => ( "eZ Publish SQL Isbn data dump\n\n" .
                                                        "Dump sql data to file or standard output from the tables:\n" .
                                                        "  ezisbn_group\n" .
                                                        "  ezisbn_group_range\n" .
                                                        "  ezisbn_registrant_range\n\n" .
                                                        "Default is file, wich will be written to:\n" .
                                                        "  kernel/classes/datatypes/ezisbn/sql/<database>/cleandata.sql\n" .
                                                        "  kernel/classes/datatypes/ezisbn/share/db_data.dba\n\n" .
                                                        "Script can be run as:\n" .
                                                        "php bin/php/ezsqldumpisbndata.php --stdout-sql\n" .
                                                        "                                  --stdout-dba\n" .
                                                        "                                  --filename-sql=customname.sql\n" .
                                                        "                                  --filename-dba=customname.dba" ),
                                     'use-session' => false,
                                     'use-modules' => true,
                                     'use-extensions' => true ) );

$script->startup();

 $options = $script->getOptions( "[stdout-sql][stdout-dba][filename-sql:][filename-dba:][db-host:][db-user:][db-password:][db-database:][db-driver:]", "",

                                array( 'stdout-sql' => "Result of sql output will be printed to standard output instead of to file.",
                                       'stdout-dba' => "Result of dba output will be printed to standard output instead of to file.",
                                       'filename-sql' => "Custom name for the sql file. Will be stored in the directory: \n" .
                                                         "kernel/classes/datatypes/ezisbn/sql/<database>/",
                                       'filename-dba' => "Custom name for the dba file. Will be stored in the directory: \n" .
                                                         "kernel/classes/datatypes/ezisbn/share/",
                                       'db-host' => "Database host.",
                                       'db-user' => "Database user.",
                                       'db-password' => "Database password.",
                                       'db-database' => "Database name.",
                                       'db-driver' => "Database driver." ) );
$script->initialize();
$db = eZDB::instance();

if( !$db->IsConnected )
{
 // default settings are not valid
 // try user-defined settings

 $dbUser = $options['db-user'] ? $options['db-user'] : false;
 $dbPassword = $options['db-password'] ? $options['db-password'] : false;
 $dbHost = $options['db-host'] ? $options['db-host'] : false;
 $dbName = $options['db-database'] ? $options['db-database'] : false;
 $dbImpl = $options['db-driver'] ? $options['db-driver'] : false;

 if ( $dbHost or $dbName or $dbUser or $dbImpl )
 {
     $params = array();
     if ( $dbHost !== false )
         $params['server'] = $dbHost;
     if ( $dbUser !== false )
     {
         $params['user'] = $dbUser;
         $params['password'] = '';
     }
     if ( $dbPassword !== false )
         $params['password'] = $dbPassword;
     if ( $dbName !== false )
         $params['database'] = $dbName;
     $db =& eZDB::instance( $dbImpl, $params, true );
     eZDB::setInstance( $db );
 }

 // still no success?
 if( !$db->IsConnected )
 {
     $cli->error( "Error: couldn't connect to database '" . $db->DB . "'" );
     $cli->error( '       for mysql try: ' );
     $cli->error( '          mysql -e "create database ' . $db->DB . ';"' );
     $cli->error( '          mysql tmp < kernel/sql/mysql/kernel_schema.sql' );
     $cli->error( '       or use --help for more info' );

     $script->shutdown( 1 );
 }
}

$dbSchema = eZDbSchema::instance( $db );

if ( isset( $options['filename-sql'] ) )
{
    $fileNameSql = $options['filename-sql'];
}

if ( isset( $options['filename-dba'] ) )
{
    $fileNameDba = $options['filename-dba'];
}

if ( isset( $options['stdout-sql'] ) !== null )
{
    $stdOutSQL = $options['stdout-sql'];
}

if ( isset( $options['stdout-dba'] ) !== null )
{
    $stdOutDBA = $options['stdout-dba'];
}

$tableType = $db->databaseName() === 'mysql' ? 'InnoDB' : null;

$includeSchema = false;
$includeData = true;

$dbschemaParameters = array( 'schema' => $includeSchema,
                             'data' => $includeData,
                             'format' => 'generic',
                             'meta_data' => null,
                             'table_type' => $tableType,
                             'table_charset' => null,
                             'compatible_sql' => true,
                             'allow_multi_insert' => null,
                             'diff_friendly' => null,
                             'table_include' => array( 'ezisbn_group',
                                                       'ezisbn_group_range',
                                                       'ezisbn_registrant_range' ) );

if ( $stdOutDBA === null and $stdOutSQL === null )
{
    $path = 'kernel/classes/datatypes/ezisbn/sql/' . $db->databaseName() . '/';
    $file = $path . $fileNameSql;
    $dbSchema->writeSQLSchemaFile( $file,
                                   $dbschemaParameters );
    $cli->output( 'Write "' . $file . '" to disk.' );

    $path = 'kernel/classes/datatypes/ezisbn/share/';
    $file = $path . $fileNameDba;

    // Add the table schema.
    $dbSchema->writeArraySchemaFile( $file,
                                     $dbschemaParameters );
    $cli->output( 'Write "' . $file . '" to disk.' );
}
else
{
    $filename = 'php://stdout';
    if ( $stdOutSQL !== null )
    {
        $dbSchema->writeSQLSchemaFile( $filename,
                                       $dbschemaParameters );
    }

    if ( $stdOutDBA !== null )
    {
        $dbschemaParameters['schema'] = true;
        $dbSchema->writeArraySchemaFile( $filename,
                                         $dbschemaParameters );
    }
}


$script->shutdown();
?>
