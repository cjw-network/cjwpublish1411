<?php
/**
 * This file is part of the Qafoo RMF Component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF;

use \PHPUnit_Framework_TestSuite;
use \Qafoo\RMF\TestCase;

require_once __DIR__ . '/TestCase.php';

/**
 * @version $Revision$
 *
 * @covers \Qafoo\RMF\Request
 * @group rmf
 * @group unittest
 */
class RequestTest extends TestCase
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
        $request = new Request();
        $request->unhandledProperty;
    }

    public function testSimpleHandlerCall()
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

    public function testCachedPropertyHandler()
    {
        $handler = $this->getMock( '\Qafoo\RMF\Request\PropertyHandler', array( 'getValue' ) );
        $handler
            ->expects( $this->once() )
            ->method( 'getValue' )
            ->will( $this->returnValue( '127.0.0.1' ) );

        $request = new Request( array(
            'remoteAddr' => $handler,
        ) );

        $request->remoteAddr;
        $this->assertSame(
            '127.0.0.1',
            $request->remoteAddr
        );
    }

    public function testSetValue()
    {
        $request = new Request();
        $request->something = 'foo';

        $this->assertSame(
            'foo',
            $request->something
        );
    }
}
