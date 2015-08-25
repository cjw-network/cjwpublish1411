<?php
/**
 * This file is part of the Qafoo RMF Component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Dispatcher;
use Qafoo\RMF\Router;
use Qafoo\RMF\View;
use Qafoo\RMF\Request;

use \PHPUnit_Framework_TestSuite;
use \Qafoo\RMF\TestCase;

require_once __DIR__ . '/../TestCase.php';

/**
 * Controller stub
 */
class Controller
{
    public function action()
    {
        // Stub
    }
}

/**
 * @version $Revision$
 *
 * @covers \Qafoo\RMF\Dispatcher\Simple
 * @group rmf
 * @group unittest
 */
class SimpleTest extends TestCase
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

    public function testCommonDispatching()
    {
        $request = new Request();

        $controller = $this->getMock( '\Qafoo\RMF\Dispatcher\Controller', array( 'action' ) );
        $controller->expects( $this->once() )->method( 'action' )->will( $this->returnValue( null ) );

        $router = $this->getMock( '\Qafoo\RMF\Router', array( 'getRoutingInformation' ) );
        $router->expects( $this->once() )->method( 'getRoutingInformation' )->will( $this->returnValue( array( $controller, 'action' ) ) );

        $view = $this->getMock( '\Qafoo\RMF\View', array( 'display' ) );
        $view->expects( $this->once() )->method( 'display' )->with( $request, null );

        $dispatcher = new Simple( $router, $view );
        $dispatcher->dispatch( $request );
    }

    public function testRouterThrowsException()
    {
        $request = new Request();

        $controller = $this->getMock( '\Qafoo\RMF\Dispatcher\Controller', array( 'action' ) );
        $controller->expects( $this->never() )->method( 'action' );

        $router = $this->getMock( '\Qafoo\RMF\Router', array( 'getRoutingInformation' ) );
        $router->expects( $this->once() )->method( 'getRoutingInformation' )->will( $this->throwException( $e = new \Exception() ) );

        $view = $this->getMock( '\Qafoo\RMF\View', array( 'display' ) );
        $view->expects( $this->once() )->method( 'display' )->with( $request, $e );

        $dispatcher = new Simple( $router, $view );
        $dispatcher->dispatch( $request );
    }

    public function testControllerThrowsException()
    {
        $request = new Request();

        $controller = $this->getMock( '\Qafoo\RMF\Dispatcher\Controller', array( 'action' ) );
        $controller->expects( $this->once() )->method( 'action' )->will( $this->throwException( $e = new \Exception() ) );

        $router = $this->getMock( '\Qafoo\RMF\Router', array( 'getRoutingInformation' ) );
        $router->expects( $this->once() )->method( 'getRoutingInformation' )->will( $this->returnValue( array( $controller, 'action' ) ) );

        $view = $this->getMock( '\Qafoo\RMF\View', array( 'display' ) );
        $view->expects( $this->once() )->method( 'display' )->with( $request, $e );

        $dispatcher = new Simple( $router, $view );
        $dispatcher->dispatch( $request );
    }
}
