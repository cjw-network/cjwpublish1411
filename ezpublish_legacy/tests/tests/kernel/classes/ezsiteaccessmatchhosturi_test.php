<?php
/**
 * File containing the eZSiteAccessMatchHostUriTest class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class eZSiteAccessMatchHostUriTest extends ezpTestCase
{
    public function setUp()
    {
        parent::setUp();
        ezpINIHelper::setINISetting( "site.ini", "SiteAccessSettings", "MatchOrder", "host_uri" );
        ezpINIHelper::setINISetting(
            "site.ini",
            "SiteAccessSettings",
            "HostUriMatchMapItems",
            array(
                "www.example.com;abcd/foo;abcd_foo",
                "www.example.com;abcdef/foo;abcdef_foo",
                "www.example.com;abc/foo;abc_foo",
                "www.example.com;abcdefg/foo;abcdefg_foo",
                "www.example.com;abcde/foo;abcde_foo",
                "www.example.com;abcd;abcd",
                "www.example.com;abcdef;abcdef",
                "www.example.com;abc;abc",
                "www.example.com;abcdefg;abcdefg",
                "www.example.com;abcde;abcde",
                "www.example.com;admin;admin",
            )
        );
    }

    public function tearDown()
    {
        ezpINIHelper::restoreINISettings();
        parent::tearDown();
    }

    /**
     * Test for eZContentObject::versions(), fetching all of them
     * @dataProvider providerForTestMatchHostUri
     */
    public function testMatchHostUri( $uri, $name, $type, $uriPart )
    {
        $this->assertEquals(
            array(
                "name" => $name,
                "type" => $type,
                "uri_part" => $uriPart,
            ),
            eZSiteAccess::match(
                new eZURI( $uri ),
                "www.example.com"
            )
        );
    }

    public function providerForTestMatchHostUri()
    {
        return array(
            array( "", "admin", eZSiteAccess::TYPE_DEFAULT, array() ),
            array( "foo", "admin", eZSiteAccess::TYPE_DEFAULT, array() ),
            array( "admin", "admin", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "admin" ) ),
            array( "admin/", "admin", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "admin" ) ),
            array( "/admin", "admin", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "admin" ) ),
            array( "/admin/", "admin", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "admin" ) ),
            array( "admin/Foo", "admin", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "admin" ) ),
            array( "abc", "abc", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abc" ) ),
            array( "abcd", "abcd", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcd" ) ),
            array( "abcde", "abcde", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcde" ) ),
            array( "abcdef", "abcdef", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcdef" ) ),
            array( "abcdefg", "abcdefg", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcdefg" ) ),
            array( "abc/foo", "abc_foo", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abc", "foo" ) ),
            array( "abcd/foo", "abcd_foo", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcd", "foo" ) ),
            array( "abcde/foo", "abcde_foo", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcde", "foo" ) ),
            array( "abcdef/foo", "abcdef_foo", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcdef", "foo" ) ),
            array( "abcdefg/foo", "abcdefg_foo", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcdefg", "foo" ) ),
            array( "abc/foo/", "abc_foo", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abc", "foo" ) ),
            array( "/abcd/foo", "abcd_foo", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcd", "foo" ) ),
            array( "/abcde/foo/", "abcde_foo", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcde", "foo" ) ),
            array( "abcdef/foo/bar", "abcdef_foo", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcdef", "foo" ) ),
            array( "abcdefg/foo/abc", "abcdefg_foo", eZSiteAccess::TYPE_HTTP_HOST_URI, array( "abcdefg", "foo" ) ),
        );
    }

    /**
     * Test for eZSiteAccess::change(), washing non-latin1 chars from the site access.
     * @dataProvider providerForTestChange
     */
    public function testChange( $name, $type, $dirtyUriPart, $washedUriPart )
    {
        $this->assertEquals(
            array(
                'name' => $name,
                'type' => $type,
                'uri_part' => array( $washedUriPart )
            ),
            eZSiteAccess::change(
                array(
                    'name' => $name,
                    'type' => $type,
                    'uri_part' => array( $dirtyUriPart )
                )
            )
        );
    }

    public function providerForTestChange()
    {
        return array(
            array( 'eng', eZSiteAccess::TYPE_HTTP_HOST_URI, 'eng', 'eng' ),
            array( 'eng', eZSiteAccess::TYPE_HTTP_HOST_URI, 'engæ', 'eng' ),
            array( 'eng', eZSiteAccess::TYPE_HTTP_HOST_URI, 'engæøå', 'eng' ),
            array( 'eng', eZSiteAccess::TYPE_HTTP_HOST_URI, 'engæøåÆØÅ', 'eng' ),
            array( 'eng', eZSiteAccess::TYPE_HTTP_HOST_URI, '€eng$', 'eng' ),
            array( 'eng', eZSiteAccess::TYPE_HTTP_HOST_URI, '€åeng$ø', 'eng' ),
        );
    }
}
