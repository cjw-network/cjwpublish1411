<?php
/**
 * This file is part of the Qafoo RMF Component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF;

use \PHPUnit_Framework_TestCase;
use \PHPUnit_Framework_TestSuite;

/**
 * Base test case for the RMF Component
 *
 * @version $Revision$
 */
abstract class TestCase extends PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        spl_autoload_register( array( __CLASS__, 'autoload' ) );
    }

    public static function autoload( $class )
    {
        if ( 0 === strpos( $class, __NAMESPACE__ ) )
        {
            include __DIR__ . '/../../../src/main/' . strtr( $class, '\\', '/' ) . '.php';
        }
    }
}
