<?php
/**
 * File containing regression tests for eZTemplateTextOperator
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 *
 */

class eZTemplateTextOperatorRegression extends ezpDatabaseTestCase
{
    protected $backupGlobals = false;

    public function __construct()
    {
        parent::__construct();
        $this->setName( "eZTemplateTextOperator Regression Tests" );
    }

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Regression test for issue #15852
     *
     * indent() operator throws a warning when count parameter is negative
     */
    public function testIssue15852()
    {
        set_error_handler( 'testErrorHandler' );
        $tpl = eZTemplate::factory();
        $templateDirectory = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;

        // Static variable test
        $templateFile = "file:$templateDirectory/eztemplatetextoperator_regression_testIssue15852_static.tpl";
        $tpl->compileTemplateFile( $templateFile );
        try
        {
            $result = $tpl->fetch( $templateFile );
        }
        catch( Exception $e )
        {
            restore_error_handler();
            if ( strstr( $e->getMessage(), "str_repeat" ) !== false )
            {
                $this->fail( 'Static variable, warning thrown: ' . $e->getMessage() );
            }
            else
            {
                throw $e;
            }
        }
        $this->assertEquals( "This is a string", $result, "The original, unindented string should have been returned" );

        // Dynamic variable test
        $templateFile = "file:$templateDirectory/eztemplatetextoperator_regression_testIssue15852_dynamic.tpl";
        $tpl->compileTemplateFile( $templateFile );
        $tpl->setVariable( 'indent', -1 );

        try
        {
            $result = $tpl->fetch( $templateFile );
        }
        catch ( Exception $e )
        {
            restore_error_handler();
            if ( strstr( $e->getMessage(), "str_repeat" ) !== false )
            {
                $this->fail( 'Dynamic variable, warning thrown: ' . $e->getMessage() );
            }
            else
            {
                throw $e;
            }
        }

        $this->assertEquals( "This is a string", $result, "The original, unindented string should have been returned" );

        restore_error_handler();
    }
}

function testErrorHandler( $errno, $errstr, $errfile, $errline )
{
    throw new Exception( $errstr, $errno );
}
?>
