<?php
/**
 * This file is part of the Qafoo RMF Component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Router;
use Qafoo\RMF\Request;

use \PHPUnit_Framework_TestSuite;
use \Qafoo\RMF\TestCase;

require_once __DIR__ . '/../TestCase.php';

/**
 * @version $Revision$
 *
 * @covers \Qafoo\RMF\Router\Regexp
 * @group rmf
 * @group unittest
 */
class RegexpTest extends TestCase
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
     * @expectedException \UnexpectedValueException
     */
    public function testNoRoutes()
    {
        $router = new Regexp();

        $request = new Request();
        $request->method = 'GET';
        $request->path   = '/foo';

        $router->getRoutingInformation( $request );
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testNoMatchingRoute()
    {
        $router = new Regexp( array(
            '(bar)' => array( 'GET' => 'invalidCallback' )
        ) );

        $request = new Request();
        $request->method = 'GET';
        $request->path   = '/foo';

        $router->getRoutingInformation( $request );
    }

    public function testMatchRoute()
    {
        $router = new Regexp( array(
            '(foo)' => array( 'GET' => 'someCallback' )
        ) );

        $request = new Request();
        $request->method    = 'GET';
        $request->path      = '/foo';
        $request->variables = array();

        $this->assertSame(
            'someCallback',
            $router->getRoutingInformation( $request )
        );
    }

    public function testExtractVariables()
    {
        $router = new Regexp( array(
            '(foo/(?P<user>.*))' => array( 'GET' => 'someCallback' )
        ) );

        $request = new Request();
        $request->method    = 'GET';
        $request->path      = '/foo/someUser';
        $request->variables = array();

        $router->getRoutingInformation( $request );

        $this->assertSame(
            array(
                'user' => 'someUser',
            ),
            $request->variables
        );
    }
}
