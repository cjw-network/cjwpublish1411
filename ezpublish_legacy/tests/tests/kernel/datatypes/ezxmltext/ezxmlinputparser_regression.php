<?php
/**
 * File containing the eZXMLInputParserRegression class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class eZXMLInputParserRegression extends ezpTestCase
{
    /**
     * Parser used for the tests.
     *
     * @var eZXMLInputParser
     */
    protected $parser;

    public function setUp()
    {
        $this->parser = new eZXMLInputParser;
    }

    /**
     * Test for issue #018186: Special characters in custom-tags's xml attributes cause crash
     *
     * @link http://issues.ez.no/18186
     * @dataProvider providerForIssue18186
     */
    public function testIssue18186( $string, $expected )
    {
        $this->assertEquals(
            $expected,
            $this->parser->parseAttributes( $string )
        );
    }

    public static function providerForIssue18186()
    {
        return array(
            array(
                'attribute=" ; =x"',
                array( 'attribute' => '; =x' ),
            ),
            array(
                'attribute=" x =x"',
                array( 'attribute' => 'x =x' ),
            ),
            array(
                'attribute="x x=x"',
                array( 'attribute' => 'x x=x' ),
            ),
            array(
                'attribute="x x =x"',
                array( 'attribute' => 'x x =x' ),
            ),
        );
    }

    /**
     * Test for issue #018737: Regression in eZXMLInputParser::parseAttributes with attr='0'
     *
     * @link http://issues.ez.no/18737
     * @dataProvider providerForIssue18737
     */
    public function testIssue18737( $string, $expected )
    {
        $this->assertEquals(
            $expected,
            $this->parser->parseAttributes( $string )
        );
    }

    public static function providerForIssue18737()
    {
        return array(
            array(
                'attribute="0"',
                array( 'attribute' => '0' ),
            ),
            array(
                'attribute=""',
                array(),
            ),
        );
    }
}

?>
