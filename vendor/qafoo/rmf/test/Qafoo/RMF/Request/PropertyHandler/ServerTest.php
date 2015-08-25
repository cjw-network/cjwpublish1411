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
 * @covers \Qafoo\RMF\Request\PropertyHandler\Server
 * @group rmf
 * @group unittest
 */
class ServerTest extends TestCase
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

    public function testGetServerVariable()
    {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        $handler = new Server( 'REMOTE_ADDR' );
        $this->assertSame(
            '127.0.0.1',
            $handler->getValue()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetUnknownServerVariable()
    {
        $handler = new Server( '_UNKNOWN_VARIABLE' );
        $handler->getValue();
    }
}
