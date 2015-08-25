<?php
/**
 * File containing the CustomTagsTest class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\FieldType\Tests\XmlText\Converter;

use eZ\Publish\Core\FieldType\XmlText\Converter\CustomTags;
use PHPUnit_Framework_TestCase;
use DOMDocument;

class CustomTagsTest extends PHPUnit_Framework_TestCase
{
    public function testConvert()
    {
        $xml = <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<section
        xmlns:image="http://ez.no/namespaces/ezpublish3/image/"
        xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"
        xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/">

    <paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">
        <custom
                name="youtube"
                custom:video="//www.youtube.com/embed/MfOnq-zXXBw"
                custom:videoWidth="640"
                custom:videoHeight="380"/>
    </paragraph>
    <paragraph>Placing an <custom name="underline">image</custom></paragraph>
    <paragraph>
        <embed align="center" view="embed" size="large" object_id="149" custom:offset="0" custom:limit="5"/>
    </paragraph>
</section>
EOT;

        $dom = new DOMDocument;
        $dom->loadXML( $xml );
        $customTagConverter = new CustomTags();
        $customTagConverter->convert( $dom );

        /** @var \DOMElement $customTag */
        foreach ( $dom->getElementsByTagName( 'custom' ) as $customTag )
        {
            $name = $customTag->getAttribute( 'name' );
            switch ( $name )
            {
                case 'youtube':
                    $this->assertTrue( $customTag->hasAttribute( 'inline' ) );
                    $this->assertSame( 'false', $customTag->getAttribute( 'inline' ) );
                    break;

                case 'underline':
                    $this->assertFalse( $customTag->hasAttribute( 'inline' ) );
                    break;
            }
        }
    }
}
