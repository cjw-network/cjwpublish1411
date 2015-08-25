<?php
/**
 * File containing the eZContentObjectStateTest class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class eZContentObjectStateTest extends ezpDatabaseTestCase
{
    public function providerCreateWithInvalidIdentifier()
    {
        return array(
            array( 'WithUpperCaseChars' ),
            array( str_repeat( 'x', 46 ) )
        );
    }

    /**
     * @dataProvider providerCreateWithInvalidIdentifier
     */
    public function testCreateWithInvalidIdentifier( $identifier )
    {
        $row = array( 'identifier' => $identifier );
        $state = new eZContentObjectState( $row );
        $trans = $state->translationByLocale( 'eng-GB' );
        $trans->setAttribute( 'name', $identifier );
        $messages = array();
        $this->assertFalse( $state->isValid( $messages ), "Invalid state identifier '$identifier' was accepted" );
    }

    public function providerCreateWithvalidIdentifier()
    {
        return array(
            array( 'lowercasechars' ),
            array( str_repeat( 'x', 45 ) )
        );
    }

    /**
     * @dataProvider providerCreateWithValidIdentifier
     */
    public function testCreateWithvalidIdentifier( $identifier )
    {
        $row = array( 'identifier' => $identifier );
        $state = new eZContentObjectState( $row );
        $trans = $state->translationByLocale( 'eng-GB' );
        $trans->setAttribute( 'name', $identifier );
        $messages = array();
        $this->assertTrue( $state->isValid( $messages ), "Valid state identifier '$identifier' was refused" );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "eZContentObjectStateTest" );
    }
}

?>
