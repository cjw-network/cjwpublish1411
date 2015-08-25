#!/usr/bin/env php
<?php

require 'autoload.php';

$cli = eZCLI::instance();

$scriptSettings = array();
$scriptSettings['description'] = 'Initialize the ezurlalias_ml_incr table';
$scriptSettings['use-session'] = true;
$scriptSettings['use-modules'] = true;
$scriptSettings['use-extensions'] = true;

$script = eZScript::instance( $scriptSettings );
$script->startup();

$config = '';
$argumentConfig = '';
$optionHelp = false;
$arguments = false;
$useStandardOptions = true;

$options = $script->getOptions( $config, $argumentConfig, $optionHelp, $arguments, $useStandardOptions );
$script->initialize();

$db = eZDB::instance();

$maxIDs = $db->arrayQuery( 'SELECT MAX( id ) AS max_id FROM ezurlalias_ml', array( 'column' => 'max_id' ) );

$maxID = (int)$maxIDs[0];
$cli->output( "highest ID in ezurlalias_ml table: $maxID" );

$autoInc = $maxID + 1;

$cli->output( 'Truncating ezurlalias_ml_incr table' );
$db->query( 'TRUNCATE TABLE ezurlalias_ml_incr' );

$cli->output( 'Setting next auto_increment value to highest existing ID + 1' );

if ( $db instanceof eZMySQLiDB )
{
    $db->query( "ALTER TABLE ezurlalias_ml_incr AUTO_INCREMENT=$autoInc" );
}
else if ( $db instanceof eZOracleDB )
{
    $db->query( "DROP SEQUENCE s_urlalias_ml_incr" );
    $db->query( "CREATE SEQUENCE s_urlalias_ml_incr MINVALUE $autoInc" );
}
else
{
    $db->query( "DROP SEQUENCE ezurlalias_ml_incr_s" );
    $db->query( "CREATE SEQUENCE ezurlalias_ml_incr_s MINVALUE $autoInc" );
}

$cli->output( 'Inserting existing IDs into ezurlalias_ml_incr table' );
$db->query( "INSERT INTO ezurlalias_ml_incr (id) SELECT DISTINCT id FROM ezurlalias_ml" );

$script->shutdown( 0 );

?>
