<?php
/**
 * File containing the eZXMLTextRegression class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class eZXMLTextRegression extends ezpDatabaseTestCase
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "eZXMLText Datatype Regression Tests" );
    }

    public function setUp()
    {
        parent::setUp();
        $this->language = eZContentLanguage::addLanguage( "nor-NO", "Norsk" );
    }

    public function tearDown()
    {
        if ( $this->language instanceof eZContentLanguage )
        {
            if ( !$this->language->removeThis() )
                trigger_error( 'Could not remove language nor-NO, probably still existing content / class in this language!' );
        }

        parent::tearDown();
    }

    /**
     * Test scenario for issue #13492: Links are lost after removing version
     *
     * Test Outline
     * ------------
     * 1. Create a Folder in English containing a link (in the short_description attribute).
     * 2. Translate Folder into Norwegian containing another link (not the same link as above.)
     * 3. Remove Folder version 1. (Version 2 is created when translating).
     *
     * @result: short_description in version 2 will have an empty link.
     * @expected: short_description should contain same link as in version 1.
     * @link http://issues.ez.no/13492
     */
    public function testLinksAcrossTranslations()
    {
        ezpINIHelper::setINISetting( 'site.ini', 'RegionalSettings', 'ContentObjectLocale', 'eng-GB' );
        $xmlDataEng = '<link href="/some-where-random">a link</link>';
        $xmlDataNor = '<link href="/et-tilfeldig-sted">en link</link>';

        // Step 1: Create folder
        $folder = new ezpObject( "folder", 2 );
        $folder->name = "Folder Eng";
        $folder->short_description = $xmlDataEng;
        $folder->publish();

        $version1Xml = $folder->short_description->attribute('output')->attribute( 'output_text' );

        // Step 2: Translate folder
        $trData = array( "name" => "Folder Nor",
                         "short_description" => $xmlDataNor );
        $folder->addTranslation( "nor-NO", $trData ); // addTranslation() publishes too.

        // Step 3: Remove version 1
        $version1 = eZContentObjectVersion::fetchVersion( 1, $folder->id );
        $version1->removeThis();

        // Grab current versions data and make sure it's fresh.
        $folder->refresh();
        $version2Xml = $folder->short_description->attribute('output')->attribute( 'output_text' );

        $folder->remove();

        ezpINIHelper::restoreINISettings();
        self::assertEquals( $version1Xml, $version2Xml );
    }

    /**
     * Test for issue #15089: eZ Simplified XML input does not handle whitespace in XML attribute definitions
     *
     * @link http://issues.ez.no/15089
     */
    public function testWhiteSpaceInAttributes()
    {
        $testData = <<<END
<a href = "http://www.example.com" target = "_blank"><b>Colette Baron-Reid</b></a>
Click store draft and notice the result:
<link href=""><strong>Colette Baron-Reid</strong></link>
END;
        $folder = new ezpObject( "folder", 2 );
        $folder->name = __FUNCTION__;

        try
        {
            // Filling in the eZXMLTextType datatype will cause the provided
            // simple xml to be parsed. Unpatched this throw warnings
            // and attribute values will be lost.
            $folder->short_description = $testData;
        }
        catch ( PHPUnit_Framework_Error $e )
        {
            // CAVEAT: this test is too generic to catch the following problem specifically
            // This can only used as an indication for now.
            self::fail( "XML parser does not handle spaces in attributes" );
        }
        $folder->remove();
    }

    /**
     * Test for issue #14370: Inserting non break space doesn't work
     *
     * @note Test depends on template output!!
     * @link http://issues.ez.no/14370
     */
    public function testNonBreakSpace()
    {
        $xmlData = '<paragraph>esp&nbsp;ace</paragraph>';

        // Step 1: Create folder
        $folder = new ezpObject( "folder", 2 );
        $folder->name = "Non breaking space Test";
        $folder->short_description = $xmlData;
        $folder->publish();

        $xhtml = $folder->short_description->attribute('output')->attribute( 'output_text' );

        $folder->remove();

        self::assertEquals( '<p>esp&nbsp;ace</p>', $xhtml );
    }
}

?>
