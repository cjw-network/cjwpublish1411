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
 * @covers \Qafoo\RMF\Request\PropertyHandler\Superglobal
 * @group rmf
 * @group unittest
 */
class SuperglobalTest extends TestCase
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

    public function testGetSuperglobalVariable()
    {
        $_GET = array( 'foo' => 'bar' );

        $handler = new Superglobal( '_GET' );
        $this->assertSame(
            $_GET,
            $handler->getValue()
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetUnknownSuperglobalVariable()
    {
        $handler = new Superglobal( '_UNKNOWN_VARIABLE' );
        $handler->getValue();
    }
}
