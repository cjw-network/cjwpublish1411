<?php
/**
 * File containing the ezpDatabaseTestSuite class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

/**
 * Database backed test suite class.
 *
 * Inherit from this class if you want your test suite and all tests in the
 * suite to interact with a database.
 */
class ezpDatabaseTestSuite extends ezpTestSuite
{
    /**
     * Holds paths to custom sql files
     *
     * @var array( array( string => string ) )
     */
    protected $sqlFiles = array();

    /**
     * Controls if the database should be initialized with default data
     *
     * @var bool
     */
    protected $insertDefaultData = true;

    /**
     * Flag controlling that database is only setup once
     *
     * @var bool
     */
    protected static $isDatabaseSetup = false;

    /**
     * Sets up the database environment
     */
    protected function setUp()
    {
        if ( !ezpTestRunner::dbPerTest() && !self::$isDatabaseSetup )
        {
            $dsn = ezpTestRunner::dsn();
            $this->sharedFixture = ezpTestDatabaseHelper::create( $dsn );

            if ( $this->insertDefaultData === true )
                ezpTestDatabaseHelper::insertDefaultData( $this->sharedFixture );

            if ( count( $this->sqlFiles ) > 0 )
            {
                ezpTestDatabaseHelper::insertSqlData( $this->sharedFixture, $this->sqlFiles );
            }

            eZDB::setInstance( $this->sharedFixture );
            self::$isDatabaseSetup = true;
        }
    }
}
?>
