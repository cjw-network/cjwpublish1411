<?php

/**
 * File containing the eZSiteInstallerTest class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class eZSiteInstallerTest extends ezpDatabaseTestCase
{
    /**
     * Test case setup
     * Prepare $_SERVER variable
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->httpHost =  eZSys::serverVariable( 'HTTP_HOST' );
        eZSys::setServerVariable( 'HTTP_HOST', 'localhost' );
    }

    public function tearDown()
    {
        eZSys::setServerVariable( 'HTTP_HOST', $this->httpHost );
        parent::tearDown();
    }

    /**
     * Test created siteaccess URLs for given conditions
     *
     */
    public function testCreateSiteaccessUrls()
    {
        $installer = new eZSiteInstaller();

        /*
         * Access type: URL
         *
         */
        $params = array( 'siteaccess_list' => array( 'ezwebin_site' ),
                         'access_type' => 'url',
                         'access_type_value' => 'ezwebin_site',
                         'exclude_port_list' => array(),
                         'host' => '',
                         'host_prepend_siteaccess' => false );
        $siteaccessURLs = $installer->createSiteaccessUrls( $params );

        $this->assertEquals( $siteaccessURLs, array( 'ezwebin_site' => array( 'url' => 'localhost/ezwebin_site' ) ) );

        /*
         * Access type: HOST
         *
         */
        $params = array( 'siteaccess_list' => array( 'ezwebin_site' ),
                         'access_type' => 'host',
                         'access_type_value' => 'ezwebin.site.host',
                         'exclude_port_list' => array(),
                         'host' => '',
                         'host_prepend_siteaccess' => false );
        $siteaccessURLs = $installer->createSiteaccessUrls( $params );

        $this->assertEquals( $siteaccessURLs, array( 'ezwebin_site' => array( 'url' => 'ezwebin.site.host',
                                                                              'host' => 'ezwebin.site.host' ) ) );

        /*
         * Access type: PORT
         *
         */
        $params = array( 'siteaccess_list' => array( 'ezwebin_site' ),
                         'access_type' => 'port',
                         'access_type_value' => '81',
                         'exclude_port_list' => array(),
                         'host' => '',
                         'host_prepend_siteaccess' => false );
        $siteaccessURLs = $installer->createSiteaccessUrls( $params );

        $this->assertEquals( $siteaccessURLs, array( 'ezwebin_site' => array( 'url' => 'localhost:81',
                                                                              'port' => '81' ) ) );

        /*
         * Access type: HOST
         * Language siteaccess
         * Host with prepended siteaccess name
         *
         */
        $params = array( 'siteaccess_list' => array( 'eng' ),
                         'access_type' => 'host',
                         'access_type_value' => 'ezwebin.site.host',
                         'exclude_port_list' => array(),
                         'host' => '',
                         'host_prepend_siteaccess' => true );
        $siteaccessURLs = $installer->createSiteaccessUrls( $params );

        $this->assertEquals( $siteaccessURLs, array( 'eng' => array( 'url' => 'eng.ezwebin.site.host',
                                                                     'host' => 'eng.ezwebin.site.host' ) ) );

        /*
         * Access type: PORT
         * Excluded port 81
         */
        $params = array( 'siteaccess_list' => array( 'ezwebin_site' ),
                         'access_type' => 'port',
                         'access_type_value' => '81',
                         'exclude_port_list' => array( '81' ),
                         'host' => '',
                         'host_prepend_siteaccess' => false );
        $siteaccessURLs = $installer->createSiteaccessUrls( $params );

        $this->assertEquals( $siteaccessURLs, array( 'ezwebin_site' => array( 'url' => 'localhost:82',
                                                                              'port' => '82' ) ) );
    }
}

?>
