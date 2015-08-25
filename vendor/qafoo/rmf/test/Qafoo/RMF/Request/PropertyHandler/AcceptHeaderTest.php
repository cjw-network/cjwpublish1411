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
 * @covers \Qafoo\RMF\Request\PropertyHandler\AcceptHeader
 * @group rmf
 * @group unittest
 */
class AcceptHeaderTest extends TestCase
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

    public static function getAcceptHeaders()
    {
        return array(
            array(
                'HTTP_ACCEPT_LANGUAGE',
                '',
                array(
                    array( 'value' => 'en', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_LANGUAGE',
                'de',
                array(
                    array( 'value' => 'de', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_LANGUAGE',
                'de, en',
                array(
                    array( 'value' => 'de', 'priority' => 1. ),
                    array( 'value' => 'en', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_LANGUAGE',
                'de, en, *',
                array(
                    array( 'value' => 'de', 'priority' => 1. ),
                    array( 'value' => 'en', 'priority' => 1. ),
                    array( 'value' => '*', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_LANGUAGE',
                'de-ch, de, en',
                array(
                    array( 'value' => 'de-ch', 'priority' => 1. ),
                    array( 'value' => 'de', 'priority' => 1. ),
                    array( 'value' => 'en', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_LANGUAGE',
                'de-DE,en-GB;q=0.9,de;q=0.8,en;q=0.7,cs-CZ;q=0.5,*;q=0.1',
                array(
                    array( 'value' => 'de-de', 'priority' => 1. ),
                    array( 'value' => 'en-gb', 'priority' => .9 ),
                    array( 'value' => 'de', 'priority' => .8 ),
                    array( 'value' => 'en', 'priority' => .7 ),
                    array( 'value' => 'cs-cz', 'priority' => .5 ),
                    array( 'value' => '*', 'priority' => .1 ),
                ),
            ),
            array(
                'HTTP_ACCEPT_LANGUAGE',
                '17:01',
                array(
                    array( 'value' => 'en', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_CHARSET',
                '',
                array(
                    array( 'value' => 'utf-8', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_CHARSET',
                'UTF-8,*',
                array(
                    array( 'value' => 'utf-8', 'priority' => 1. ),
                    array( 'value' => '*', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_CHARSET',
                'iso-8859-1, utf-8, utf-16, *;q=0.1',
                array(
                    array( 'value' => 'iso-8859-1', 'priority' => 1. ),
                    array( 'value' => 'utf-8', 'priority' => 1. ),
                    array( 'value' => 'utf-16', 'priority' => 1. ),
                    array( 'value' => '*', 'priority' => .1 ),
                ),
            ),
            array(
                'HTTP_ACCEPT_CHARSET',
                'utf-8;q=1.0, windows-1251;q=0.8, cp1251;q=0.8, koi8-r;q=0.8, *;q=0.5',
                array(
                    array( 'value' => 'utf-8', 'priority' => 1. ),
                    array( 'value' => 'windows-1251', 'priority' => .8 ),
                    array( 'value' => 'cp1251', 'priority' => .8 ),
                    array( 'value' => 'koi8-r', 'priority' => .8 ),
                    array( 'value' => '*', 'priority' => .5 ),
                ),
            ),
            array(
                'HTTP_ACCEPT_ENCODING',
                '',
                array(
                    array( 'value' => 'identity', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_ENCODING',
                'deflate, gzip, x-gzip, identity, *;q=0',
                array(
                    array( 'value' => 'deflate', 'priority' => 1. ),
                    array( 'value' => 'gzip', 'priority' => 1. ),
                    array( 'value' => 'x-gzip', 'priority' => 1. ),
                    array( 'value' => 'identity', 'priority' => 1. ),
                    array( 'value' => '*', 'priority' => 0. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_ENCODING',
                'identity;q=1.0',
                array(
                    array( 'value' => 'identity', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT_ENCODING',
                'gzip;q=1.0, deflate;q=1.0, identity;q=0.5, *;q=0',
                array(
                    array( 'value' => 'gzip', 'priority' => 1. ),
                    array( 'value' => 'deflate', 'priority' => 1. ),
                    array( 'value' => 'identity', 'priority' => .5 ),
                    array( 'value' => '*', 'priority' => 0. ),
                ),
            ),
            array(
                'HTTP_ACCEPT',
                '',
                array(
                    array( 'value' => '*/*', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT',
                '*/*',
                array(
                    array( 'value' => '*/*', 'priority' => 1. ),
                ),
            ),
            array(
                'HTTP_ACCEPT',
                'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                array(
                    array( 'value' => 'text/html', 'priority' => 1. ),
                    array( 'value' => 'application/xhtml+xml', 'priority' => 1. ),
                    array( 'value' => 'application/xml', 'priority' => .9 ),
                    array( 'value' => '*/*', 'priority' => .8 ),
                ),
            ),
            array(
                'HTTP_ACCEPT',
                'text/html, text/plain, text/xml, application/*, Model/vnd.dwf, drawing/x-dwf',
                array(
                    array( 'value' => 'text/html', 'priority' => 1. ),
                    array( 'value' => 'text/plain', 'priority' => 1. ),
                    array( 'value' => 'text/xml', 'priority' => 1. ),
                    array( 'value' => 'application/*', 'priority' => 1. ),
                    array( 'value' => 'model/vnd.dwf', 'priority' => 1. ),
                    array( 'value' => 'drawing/x-dwf', 'priority' => 1. ),
                ),
            ),
        );
    }

    /**
     * @dataProvider getAcceptHeaders
     */
    public function testGetAcceptHeaderVariable( $header, $value, $expectation )
    {
        $_SERVER[$header] = $value;
        $defaults = array(
            'HTTP_ACCEPT_LANGUAGE' => 'en',
            'HTTP_ACCEPT_CHARSET'  => 'utf-8',
            'HTTP_ACCEPT_ENCODING' => 'identity',
            'HTTP_ACCEPT'          => '*/*'
        );

        $handler = new AcceptHeader( $header, $defaults[$header] );
        $this->assertSame(
            $expectation,
            $handler->getValue()
        );
    }

    public function testGetUnknownAcceptHeaderVariable()
    {
        $handler = new AcceptHeader( '_UNKNOWN_VARIABLE', null );
        $this->assertSame(
            array( array(
                'value' => null,
                'priority' => 1.,
            ) ),
            $handler->getValue()
        );
    }
}
