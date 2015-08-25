<?php
/**
 * File containing the ezpMobileDeviceDetectFilterTest class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class ezpMobileDeviceDetectFilterTest extends ezpTestCase
{
    public function setUp()
    {
        parent::setUp();

        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3';
        $_SERVER['HTTP_ACCEPT'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Tests new filter object instance creation
     *
     */
    public function testGetFilter()
    {
        $mobileDeviceDetectFilter = ezpMobileDeviceDetectFilter::getFilter();

        $this->assertNotNull( $mobileDeviceDetectFilter );
        $this->assertInstanceOf( 'ezpMobileDeviceDetectFilterInterface', $mobileDeviceDetectFilter );

        ezpINIHelper::setINISetting( 'site.ini', 'SiteAccessSettings', 'MobileDeviceFilterClass', '' );

        $mobileDeviceDetectFilter = ezpMobileDeviceDetectFilter::getFilter();

        $this->assertNull( $mobileDeviceDetectFilter );

        ezpINIHelper::restoreINISettings();
    }
}
