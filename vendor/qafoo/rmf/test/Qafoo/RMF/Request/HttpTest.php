<?php
/**
 * This file is part of the Qafoo RMF Component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request;
use Qafoo\RMF\Request;

use \PHPUnit_Framework_TestSuite;
use \Qafoo\RMF\TestCase;

require_once __DIR__ . '/../TestCase.php';

/**
 * @version $Revision$
 *
 * @covers \Qafoo\RMF\Request\Http
 * @group rmf
 * @group unittest
 */
class HTTPTest extends TestCase
{
    /**
     * Returns the test suite with all tests declared in this class.
     *
     * @return \PHPUnit_Framework_TestSuite
     */
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    /**
     * @expectedException \LogicException
     */
    public function testMissingHandler()
    {
        $request = new HTTP();
        $request->unhandledProperty;
    }

    public function setUp()
    {
        $this->oldServerArray = $_SERVER;
        $_SERVER = array(
            'REQUEST_URI' => '/foo',
            'REQUEST_METHOD' => 'GET',
        );
    }

    public function tearDown()
    {
        $_SERVER = $this->oldServerArray;
    }

    public function testGetRequestUri()
    {
        $request = new HTTP();

        $this->assertSame(
            '/foo',
            $request->path
        );
    }

    public function testGetRequestMethod()
    {
        $request = new HTTP();

        $this->assertSame(
            'GET',
            $request->method
        );
    }

    public function testAdditionalValues()
    {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $request = new Request( array(
            'remoteAddr' => new Request\PropertyHandler\Server( 'REMOTE_ADDR' ),
        ) );

        $this->assertSame(
            '127.0.0.1',
            $request->remoteAddr
        );
    }
}
