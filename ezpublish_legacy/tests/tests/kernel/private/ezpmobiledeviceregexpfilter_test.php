<?php
/**
 * File containing the ezpMobileDeviceRegexpFilterTest class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class ezpMobileDeviceRegexpFilterTest extends ezpTestCase
{
    protected $mobileDeviceDetect;

    public function setUp()
    {
        parent::setUp();

        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3';
        $_SERVER['HTTP_ACCEPT'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';

        $this->mobileDeviceDetect = $this->getMock( 'ezpMobileDeviceRegexpFilter', null );
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->mobileDeviceDetect = null;
    }

    /**
     * Tests whether mobile device detection process went fine
     *
     */
    public function testProcess()
    {
        $this->mobileDeviceDetect->process();

        $this->assertTrue( $this->mobileDeviceDetect->isMobileDevice() );
        $this->assertEquals( 'IPhoneDevice', $this->mobileDeviceDetect->getUserAgentAlias() );
    }

    /**
     * Tests if mobile device was detected properly
     *
     */
    public function testIsMobileDevice()
    {
        $this->mobileDeviceDetect->process();

        $this->assertTrue( $this->mobileDeviceDetect->isMobileDevice() );
    }

    /**
     * Tests if mobile User Agent alias was read properly from the site.ini.[SiteAccessSettings].MobileUserAgentRegexps
     *
     */
    public function testGetUserAgentAlias()
    {
        $this->mobileDeviceDetect->process();

        $this->assertEquals( 'IPhoneDevice', $this->mobileDeviceDetect->getUserAgentAlias() );
    }
}
