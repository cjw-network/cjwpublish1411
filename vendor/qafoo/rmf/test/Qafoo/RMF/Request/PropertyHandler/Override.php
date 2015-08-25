<?php
/**
 * This file is part of the Qafoo RMF Component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request\PropertyHandler;

use \PHPUnit_Framework_TestSuite;
use \Qafoo\RMF\TestCase;

require_once __DIR__ . '/../../TestCase.php';

/**
 * @version $Revision$
 *
 * @covers \Qafoo\RMF\Request\PropertyHandler\Override
 * @group rmf
 * @group unittest
 */
class OverrideTest extends TestCase
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

    public function testGetSuccessFirst()
    {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        $handler = new Override( array(
            new Server( 'REMOTE_ADDR' ),
            new Server( 'NOT_FOUND' ),
        ) );

        $this->assertSame(
            '127.0.0.1',
            $handler->getValue()
        );
    }

    public function testGetSuccessSecond()
    {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        $handler = new Override( array(
            new Server( 'NOT_FOUND' ),
            new Server( 'REMOTE_ADDR' ),
        ) );

        $this->assertSame(
            '127.0.0.1',
            $handler->getValue()
        );
    }

    /**
     * @expectedException Qafoo\RMF\Request\PropertyHandler\Override\NoValueFoundException
     */
    public function testGetFailureNoInnerHandlers()
    {
        $handler = new Override();
        $handler->getValue();
    }

    /**
     * @expectedException Qafoo\RMF\Request\PropertyHandler\Override\NoValueFoundException
     */
    public function testGetFailureNoValueFound()
    {
        $handler = new Override( array(
            new Server( 'NOT_FOUND' ),
        ) );
        $handler->getValue();
    }
}
