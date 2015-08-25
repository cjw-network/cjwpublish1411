<?php
/**
 * File containing the eZURIRegression class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class eZURIRegression extends ezpTestCase
{
    /**
     * @var eZSys
     */
    private $oldSysInstance;

    private $queryString;

    public function setUp()
    {
        parent::setUp();
        // Backup previous instance of eZSys (if any) and reset it
        $this->oldSysInstance = eZSys::instance();
        eZSys::setInstance();

        // Set the RequestURI to a known value so that eZSys::requestURI()
        // returns something known and useful.
        $this->queryString = "?foo=bar&this=that";
        eZSys::setServerVariable( "REQUEST_URI", "/all/work/and/no/sleep/makes/(ole)/a/(dull)/boy{$this->queryString}" );
        eZSys::init();
    }

    public function tearDown()
    {
        // Make sure to restore eZSys instance in case other tests depends on it
        eZSys::setInstance( $this->oldSysInstance );
        parent::tearDown();
    }

    /**
     * Test scenario for issue #13186: UserParameters works differently in 4.0 compared to 3.10
     *
     * @result $eZURI->userParameters() returns an empty array
     * @expected $eZURI->userParameters() should return array( "ole" => "a", "dull" => "boy" ).
     *
     * @link http://issues.ez.no/13186
     * @group ezuri_regression
     */
    public function testUserParameters()
    {
        self::assertEquals( array( "ole" => "a", "dull" => "boy" ), eZURI::instance()->userParameters() );
    }

    /**
     * Test scenario for issue #18449 : Can't print search results in MSIE
     * Main problem is to be able to get the query string out of eZURI
     * @link http://issues.ez.no/18449
     * @group issue18449
     * @group ezuri_regression
     */
    public function testQueryString()
    {
        self::assertEquals( $this->queryString, eZURI::instance()->attribute( "query_string" ) );
    }

    /**
     * Test for issue EZP-21325
     * @dataProvider providerKeepSlashesUserParameters
     * @link https://jira.ez.no/browse/EZP-21325
     */
    public function testKeepSlashesUserParameters( $url, $userParameters )
    {
        $uri = new eZURI( $url );
        $this->assertEmpty(
            array_diff(
                $uri->userParameters(),
                $userParameters
            )
        );
    }

    public function providerKeepSlashesUserParameters()
    {
        return array(
            array(
                '/(url)/ez.no/(other)/share.ez.no',
                array(
                    'url' => 'ez.no',
                    'other' => 'share.ez.no',
                )
            ),
            array(
                '/(url)/http://ez.no/(other)/http://share.ez.no',
                array(
                    'url' => 'http://ez.no',
                    'other' => 'http://share.ez.no',
                )
            ),
            array(
                '/(redirect)/http://ez.no',
                array( 'redirect' => 'http://ez.no' )
            ),
            array(
                '/(param)/segment1////test2',
                array( 'param' => 'segment1////test2' )
            ),
            array(
                '/(p)/segment1/test2/(r)/http://ez.no',
                array(
                    'p' => 'segment1/test2',
                    'r' => 'http://ez.no'
                )
            ),
            array(
                '/(p)/segment1////test2/(r)/http://ez.no',
                array(
                    'p' => 'segment1////test2',
                    'r' => 'http://ez.no'
                )
            )
        );
    }
}

?>
