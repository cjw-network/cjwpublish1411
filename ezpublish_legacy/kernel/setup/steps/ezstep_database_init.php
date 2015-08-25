<?php
/**
 * File containing the eZStepDatabaseInit class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZStepDatabaseInit ezstep_database_init.php
  \brief The class eZStepDatabaseInit does

*/

class eZStepDatabaseInit extends eZStepInstaller
{
    /*!
     Constructor
    */
    function eZStepDatabaseInit( $tpl, $http, $ini, &$persistenceList )
    {
        $this->eZStepInstaller( $tpl, $http, $ini, $persistenceList,
                                'database_init', 'Database init' );
    }

    function processPostData()
    {
        $databaseMap = eZSetupDatabaseMap();

        // Get database parameters from input form.
        if ( $this->Http->hasPostVariable( 'eZSetupDatabaseServer' ) )
            $this->PersistenceList['database_info']['server'] = $this->Http->postVariable( 'eZSetupDatabaseServer' );
        if ( $this->Http->hasPostVariable( 'eZSetupDatabasePort' ) )
            $this->PersistenceList['database_info']['port'] = $this->Http->postVariable( 'eZSetupDatabasePort' );
        if ( $this->Http->hasPostVariable( 'eZSetupDatabaseName' ) )
            $this->PersistenceList['database_info']['dbname'] = $this->Http->postVariable( 'eZSetupDatabaseName' );
        if ( $this->Http->hasPostVariable( 'eZSetupDatabaseUser' ) )
            $this->PersistenceList['database_info']['user'] = $this->Http->postVariable( 'eZSetupDatabaseUser' );
        if ( $this->Http->hasPostVariable( 'eZSetupDatabaseSocket' ) )
            $this->PersistenceList['database_info']['socket'] = $this->Http->postVariable( 'eZSetupDatabaseSocket' );
        if ( !isset( $this->PersistenceList['database_info']['socket'] ) )
            $this->PersistenceList['database_info']['socket'] = false;
        if ( !isset( $this->PersistenceList['database_info']['database'] ) )
            $this->PersistenceList['database_info']['database'] = false;


        $this->Error = 0;
        $dbStatus = false;

        // Get password
        if ( isset( $this->PersistenceList['database_info']['password'] ) )
        {
            $password = $this->PersistenceList['database_info']['password'];
        }

        if ( $this->Http->hasPostVariable( 'eZSetupDatabasePassword' ) )
        {
            $password = $this->Http->postVariable( 'eZSetupDatabasePassword' );
            $this->PersistenceList['database_info']['password'] = $password;
        }

        $databaseChoice = false;

        // Check database connection
        $databaseInfo = $this->PersistenceList['database_info'];
        $databaseInfo['info'] = $databaseMap[$databaseInfo['type']];
        if ( isset( $this->PersistenceList['regional_info'] ) )
        {
            $regionalInfo = $this->PersistenceList['regional_info'];
        }
        else
        {
            $regionalInfo = '';
        }

        $this->PersistenceList['database_info']['password'] = $password;

        $result = $this->checkDatabaseRequirements( false );

        $this->PersistenceList['database_info']['version'] = $result['db_version'];
        if ( isset( $result['db_required_version'] ) )
            $this->PersistenceList['database_info']['required_version'] = $result['db_required_version'];
        if ( !$result['status'] )
        {
            $this->Error = $result['error_code'];
            return false;
        }

        $db = $result['db_instance'];
        $this->PersistenceList['database_info']['use_unicode'] = $result['use_unicode'];
        $availDatabases = $db->availableDatabases();

        if ( $availDatabases === false ) // not possible to determine if username and password is correct here
        {
            return true;
        }
        else if ( count( $availDatabases ) > 0 ) // login succeeded, and at least one database available
        {
            $this->PersistenceList['database_info_available'] = $availDatabases;
            return true;
        }
        else if ( $availDatabases == null && $db->isConnected() === true )
        {
            $this->Error = eZStepInstaller::DB_ERROR_NO_DATABASES;
            return false;
        }

        $this->Error = eZStepInstaller::DB_ERROR_CONNECTION_FAILED;

        return false;
    }

    function init()
    {
        if ( $this->hasKickstartData() )
        {
            $data = $this->kickstartData();

            // Fill in database info in persistence list
            // This is needed for db requirement check
            $this->PersistenceList['database_info']['server'] = $data['Server'];
            $this->PersistenceList['database_info']['port'] = $data['Port'];
            $this->PersistenceList['database_info']['dbname'] = $data['Database'];
            $this->PersistenceList['database_info']['user'] = $data['User'];
            $this->PersistenceList['database_info']['password'] = $data['Password'];
            $this->PersistenceList['database_info']['socket'] = $data['Socket'];
            $this->PersistenceList['database_info']['database'] = $data['Database'];

            $result = $this->checkDatabaseRequirements( false );

            $this->PersistenceList['database_info']['version'] = $result['db_version'];
            if ( isset( $result['db_required_version'] ) )
            {
                $this->PersistenceList['database_info']['required_version'] = $result['db_required_version'];
            }
            if ( !$result['status'] )
            {
                $this->Error = $result['error_code'];
                return false;
            }

            $this->PersistenceList['database_info']['use_unicode'] = $result['use_unicode'];

            return $this->kickstartContinueNextStep();
        }

        // If using windows installer, set standard values, and continue
/*        if ( eZSetupTestInstaller() == 'windows' )
        {
            $this->PersistenceList['database_info']['server'] = 'localhost';
            $this->PersistenceList['database_info']['user'] = 'root';
            $this->PersistenceList['database_info']['password'] = '';
            return true;
        }*/

        $config = eZINI::instance( 'setup.ini' );
        if ( !isset( $this->PersistenceList['database_info']['server'] ) or
             !$this->PersistenceList['database_info']['server'] )
            $this->PersistenceList['database_info']['server'] = $config->variable( 'DatabaseSettings', 'DefaultServer' );
        if ( !isset( $this->PersistenceList['database_info']['port'] ) or
             !$this->PersistenceList['database_info']['port'] )
            $this->PersistenceList['database_info']['port'] = $config->variable( 'DatabaseSettings', 'DefaultPort' );
        if ( !isset( $this->PersistenceList['database_info']['dbname'] ) or
             !$this->PersistenceList['database_info']['dbname'] )
            $this->PersistenceList['database_info']['dbname'] = $config->variable( 'DatabaseSettings', 'DefaultName' );
        if ( !isset( $this->PersistenceList['database_info']['user'] ) or
             !$this->PersistenceList['database_info']['user'] )
            $this->PersistenceList['database_info']['user'] = $config->variable( 'DatabaseSettings', 'DefaultUser' );
        if ( !isset( $this->PersistenceList['database_info']['password'] ) or
             !$this->PersistenceList['database_info']['password'] )
            $this->PersistenceList['database_info']['password'] = $config->variable( 'DatabaseSettings', 'DefaultPassword' );
        if ( !isset( $this->PersistenceList['database_info']['socket'] ) )
            $this->PersistenceList['database_info']['socket'] = '';

        if ( $this->Http->postVariable( 'eZSetup_current_step' ) == 'SiteDetails' ) // Failed to connect to tables in database
        {
            $this->Error = eZStepInstaller::DB_ERROR_CONNECTION_FAILED;
        }

        return false; // Always show database initialization
    }

    function display()
    {
        $databaseMap = eZSetupDatabaseMap();

        $dbError = 0;
        $dbNotEmpty = 0;
        if ( $this->Error )
        {
            $dbError = $this->databaseErrorInfo( array( 'error_code' => $this->Error,
                                                        'database_info' => $this->PersistenceList['database_info'] ) );
        }

        $databaseInfo = $this->PersistenceList['database_info'];
        $databaseInfo['info'] = $databaseMap[$databaseInfo['type']];
        $databaseInfo['table']['is_empty'] = $this->DBEmpty;
        if ( isset( $this->PersistenceList['regional_info'] ) )
        {
            $regionalInfo = $this->PersistenceList['regional_info'];
        }
        else
        {
            $regionalInfo = '';
        }

        $this->Tpl->setVariable( 'db_error', $dbError );
        $this->Tpl->setVariable( 'database_info', $databaseInfo );
        $this->Tpl->setVariable( 'regional_info', $regionalInfo );
        $this->Tpl->setVariable( 'db_not_empty', $dbNotEmpty );

        $result = array();
        // Display template
        $result['content'] = $this->Tpl->fetch( 'design:setup/init/database_init.tpl' );
        $result['path'] = array( array( 'text' => ezpI18n::tr( 'design/standard/setup/init',
                                                          'Database initialization' ),
                                        'url' => false ) );
        return $result;
    }

    public $Error = 0;
    public $DBEmpty = true;
}

?>
