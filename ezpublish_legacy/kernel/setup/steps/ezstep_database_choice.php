<?php
/**
 * File containing the eZStepDatabaseChoice class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZStepDatabaseChoice ezstep_database_choice.php
  \brief The class eZStepDatabaseChoice does

*/

class eZStepDatabaseChoice extends eZStepInstaller
{
    /*!
     Constructor
    */
    function eZStepDatabaseChoice( $tpl, $http, $ini, &$persistenceList )
    {
        $this->eZStepInstaller( $tpl, $http, $ini, $persistenceList,
                                'database_choice', 'Database choice' );
    }

    function processPostData()
    {
        $databaseMap = eZSetupDatabaseMap();
        $this->PersistenceList['database_info'] = $databaseMap[$this->Http->postVariable( 'eZSetupDatabaseType' )];
        return true;
    }

    function init()
    {
        $databaseMap = eZSetupDatabaseMap();

        if ( $this->hasKickstartData() )
        {
            $data = $this->kickstartData();
            $extension = $data['Type'];
            $map = array( 'postgresql' => 'pgsql' );
            if ( isset( $map[$extension] ) )
                $extension = $map[$extension];

            if ( isset( $databaseMap[$extension] ) )
            {
                $this->PersistenceList['database_info'] = $databaseMap[$extension];
                return $this->kickstartContinueNextStep();
            }
        }

        if ( eZSetupTestInstaller() == 'windows' )
        {
            $this->PersistenceList['database_info'] = $databaseMap['mysql'];
            return true;
        }

        $databaseMap = eZSetupDatabaseMap();
        $database = null;
        $databaseCount = 0;
        if ( isset( $this->PersistenceList['database_extensions']['found'] ) )
        {
            $databaseExtensions = $this->PersistenceList['database_extensions']['found'];
            foreach ( $databaseExtensions as $extension )
            {
                if ( !isset( $databaseMap[$extension] ) )
                    continue;
                $database = $databaseMap[$extension];
                $database['name'] = null;
                $databaseCount++;
            }
        }

        if ( $databaseCount != 1 )
        {
            return false;
        }

        $this->PersistenceList['database_info'] = $database;

        return true;
    }

    function display()
    {
        $databaseMap = eZSetupDatabaseMap();
        $availableDatabases = array();
        $databaseList = array();
        if ( isset( $this->PersistenceList['database_extensions']['found'] ) )
        {
            $databaseExtensions = $this->PersistenceList['database_extensions']['found'];
            foreach ( $databaseExtensions as $extension )
            {
                if ( !isset( $databaseMap[$extension] ) )
                    continue;
                $databaseList[] = $databaseMap[$extension];
                if ( $databaseMap[$extension]['type'] == 'mysql' or $databaseMap[$extension]['type'] == 'mysqli' )
                {
                    $availableDatabases['mysql'] = true;
                }
                elseif ( $databaseMap[$extension]['type'] == 'postgresql' )
                {
                    $availableDatabases['postgresql'] = true;
                }
            }
        }

        $databaseInfo = $databaseList[0];
        if ( isset( $this->PersistenceList['database_info'] ) )
            $databaseInfo = $this->PersistenceList['database_info'];

        $this->Tpl->setVariable( 'database_list', $databaseList );
        $this->Tpl->setVariable( 'database_info', $databaseInfo );
        $this->Tpl->setVariable( 'available_databases', $availableDatabases );

        $result = array();
        // Display template
        $result['content'] = $this->Tpl->fetch( "design:setup/init/database_choice.tpl" );
        $result['path'] = array( array( 'text' => ezpI18n::tr( 'design/standard/setup/init',
                                                          'Database choice' ),
                                        'url' => false ) );
        return $result;
    }

}

?>
