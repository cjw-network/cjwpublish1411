<?php
/**
 * This file is part of the Qafoo RMF Component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\View;
use Qafoo\RMF\Request;

use \PHPUnit_Framework_TestSuite;
use \Qafoo\RMF\TestCase;

require_once __DIR__ . '/../TestCase.php';

/**
 * @version $Revision$
 *
 * @covers \Qafoo\RMF\Request
 * @group rmf
 * @group unittest
 */
class AcceptHeaderViewDispatcherTest extends TestCase
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

    public function testDispatchFirstView()
    {
        $request = new Request();
        $request->mimetype = array(
            array(
                'priority' => 1,
                'value'    => 'text/html',
            ),
        );

        $htmlView = $this->getMock( '\Qafoo\RMF\View' );
        $htmlView
            ->expects( $this->once() )
            ->method( 'display' )
            ->with( $request, 42 );

        $view = new AcceptHeaderViewDispatcher( array(
            '(text/html)' => $htmlView,
        ) );
        $view->display( $request, 42 );
    }

    public function testDispatchSecondMimeType()
    {
        $request = new Request();
        $request->mimetype = array(
            array(
                'priority' => 1,
                'value'    => 'text/html',
            ),
            array(
                'priority' => .9,
                'value'    => 'text/xml',
            ),
        );

        $xmlView = $this->getMock( '\Qafoo\RMF\View' );
        $xmlView
            ->expects( $this->once() )
            ->method( 'display' )
            ->with( $request, 42 );

        $view = new AcceptHeaderViewDispatcher( array(
            '(text/xml)' => $xmlView,
        ) );
        $view->display( $request, 42 );
    }

    public function testDispatchSecondView()
    {
        $request = new Request();
        $request->mimetype = array(
            array(
                'priority' => 1,
                'value'    => 'text/html',
            ),
            array(
                'priority' => .9,
                'value'    => 'text/xml',
            ),
        );

        $xmlView = $this->getMock( '\Qafoo\RMF\View' );
        $xmlView
            ->expects( $this->never() )
            ->method( 'display' );

        $htmlView = $this->getMock( '\Qafoo\RMF\View' );
        $htmlView
            ->expects( $this->once() )
            ->method( 'display' )
            ->with( $request, 42 );

        $view = new AcceptHeaderViewDispatcher( array(
            '(text/html)' => $htmlView,
            '(text/xml)'  => $xmlView,
        ) );
        $view->display( $request, 42 );
    }

    /**
     * @expectedException \Qafoo\RMF\View\NowViewFoundException
     */
    public function testNoViewFound()
    {
        $request = new Request();
        $request->mimetype = array(
            array(
                'priority' => 1,
                'value'    => 'text/html',
            ),
        );

        $xmlView = $this->getMock( '\Qafoo\RMF\View' );
        $xmlView
            ->expects( $this->never() )
            ->method( 'display' );

        $view = new AcceptHeaderViewDispatcher( array(
            '(text/xml)'  => $xmlView,
        ) );
        $view->display( $request, 42 );
    }
}
