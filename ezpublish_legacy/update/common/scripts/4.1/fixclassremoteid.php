#!/usr/bin/env php
<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

if ( !function_exists( 'readline' ) )
{
    function readline( $prompt = '' )
    {
        echo $prompt . ' ';
        return trim( fgets( STDIN ) );
    }
}

require 'autoload.php';

$cli = eZCLI::instance();

$scriptSettings = array();
$scriptSettings['description'] = 'Fix non-unique usage of content class remote ID\'s';
$scriptSettings['use-session'] = false;
$scriptSettings['use-modules'] = false;
$scriptSettings['use-extensions'] = true;

$script = eZScript::instance( $scriptSettings );
$script->startup();

$config = '[mode:]';
$argumentConfig = '';
$optionHelp = array( 'mode' => "the fixing mode to use, either d (detailed) or a (automatic)" );
$arguments = false;
$useStandardOptions = true;

$options = $script->getOptions( $config, $argumentConfig, $optionHelp, $arguments, $useStandardOptions );
$script->initialize();

if ( isset( $options['mode'] ) )
{
    if ( !in_array( $options['mode'], array( 'a', 'd' ) ) )
    {
        $script->shutdown( 1, 'Invalid mode. Use either d for detailed or a for automatic.' );
    }

    $mode = $options['mode'];
}
else
{
    $mode = false;
}


$db = eZDB::instance();

$cli->output( '' );
$cli->output( 'Removing temporary content classes...' );
eZContentClass::removeTemporary();
$cli->output( '' );

$nonUniqueRemoteIDDataList = $db->arrayQuery( 'SELECT COUNT( id ) AS cnt, remote_id FROM ezcontentclass GROUP BY remote_id HAVING COUNT( id ) > 1' );

$nonUniqueRemoteIDDataListCount = count( $nonUniqueRemoteIDDataList );

$cli->output( '' );
$cli->output( "Found $nonUniqueRemoteIDDataListCount non-unique content class remote IDs." );
$cli->output( '' );

$totalCount = 0;

foreach ( $nonUniqueRemoteIDDataList as $nonUniqueRemoteIDData )
{
    if ( $mode )
    {
        $cli->output( "Remote ID '$nonUniqueRemoteIDData[remote_id]' is used for $nonUniqueRemoteIDData[cnt] different content classes." );
        $action = $mode;
    }
    else
    {
        $action = readline( "Remote ID '$nonUniqueRemoteIDData[remote_id]' is used for $nonUniqueRemoteIDData[cnt] different content classes. Do you want to see the details (d) or do you want this inconsistency to be fixed automatically (a) ?" );

        while ( !in_array( $action, array( 'a', 'd' ) ) )
        {
            $action = readline( 'Invalid option. Type either d for details or a to fix automatically.' );
        }
    }

    $escapedRemoteID = $db->escapeString( $nonUniqueRemoteIDData['remote_id'] );

    $sql = "SELECT id, identifier, created FROM ezcontentclass WHERE remote_id='$escapedRemoteID' ORDER by created ASC";
    $rows = $db->arrayQuery( $sql );

    switch ( $action )
    {
        case 'd':
        {
            $cli->output( '' );
            $cli->output( 'Select the number of the content class that you want to keep the current remote ID. The other listed content classes will get a new one.' );
            $cli->output( '' );

            foreach ( $rows as $i => $row )
            {
                $dateTime = new eZDateTime( $row['created'] );
                $formattedDateTime = $dateTime->toString( true );
                $cli->output( "$i) $row[identifier] (class ID: $row[id], created: $formattedDateTime )" );
                $cli->output( '' );
            }

            do {
                $skip = readline( 'Number of class that should keep the current remote ID: ' );
            } while ( !array_key_exists( $skip, $rows ) );
        } break;

        case 'a':
        default:
        {
            $skip = 0;
        }
    }

    $cli->output( 'Fixing...' );

    foreach ( $rows as $i => $row )
    {
        if ( $i == $skip )
        {
            continue;
        }

        $escapedNewRemoteID = $db->escapeString( eZRemoteIdUtility::generate( 'class' ) );
        $db->query( "UPDATE ezcontentclass SET remote_id='$escapedNewRemoteID' WHERE id=$row[id]" );
    }

    $totalCount += $nonUniqueRemoteIDData['cnt'] - 1;

    $cli->output( '' );
    $cli->output( '' );
}

$cli->output( "Number of content classes that received a new remote ID : $totalCount" );

$script->shutdown( 0 );

?>
