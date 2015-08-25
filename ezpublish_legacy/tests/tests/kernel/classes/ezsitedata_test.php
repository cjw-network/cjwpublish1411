<?php
/**
 * File containing the eZSiteDataTest class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class eZSiteDataTest extends ezpDatabaseTestCase
{
    /**
     * Unit test for eZPersistentObject implementation
     */
    public function testPersistentObjectInterface()
    {
        $this->assertTrue( is_subclass_of( 'eZSiteData', 'eZPersistentObject' ) );
        $this->assertTrue( method_exists( 'eZSiteData', 'definition' ) );
    }

    /**
     * Unit test for good eZPersistentObject (ORM) implementation for ezsite_data table
     */
    public function testORMImplementation()
    {
        $def = eZSiteData::definition();
        $this->assertEquals( 'eZSiteData', $def['class_name'] );
        $this->assertEquals( 'ezsite_data', $def['name'] );

        $fields = $def['fields'];
        $this->assertArrayHasKey( 'name', $fields );
        $this->assertArrayHasKey( 'value', $fields );
    }

    /**
     * Unit test for fetchByName() method
     */
    public function testFetchByName()
    {
        $name = 'foo';
        $row = array(
            'name'      => $name,
            'value'     => 'bar'
        );

        $obj = new eZSiteData( $row );
        $obj->store();
        unset( $obj );

        $res = eZSiteData::fetchByName( $name );
        $this->assertInstanceOf( 'eZSiteData', $res );

        $res->remove();
    }
}

?>
