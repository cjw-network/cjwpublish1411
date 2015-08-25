<?php
/**
 * File containing the eZContentFunctionCollectionRegression class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class eZContentFunctionCollectionRegression extends ezpDatabaseTestCase
{
    protected $backupGlobals = false;

    public function __construct()
    {
        parent::__construct();
        $this->setName( "eZContentFunctionCollection Regression Tests" );
    }

    /**
     * Test for issue #15230: php fatal error in fetch reverse_related_object
     *
     * This tests checks that eZContentFunctionCollection::fetchReverseRelatedObjects
     * and eZContentFunctionCollection::fetchRelatedObjectsCount won't throw a
     * fatal error if provided with a non-existing object ID
     *
     * @link http://issues.ez.no/15230
     */
    public function testIssue15230()
    {
        $nonExistingArticleID = 100000000;

        $this->assertFalse(
            eZContentFunctionCollection::fetchRelatedObjects( $nonExistingArticleID, false, true, false, false ),
            "eZContentFunctionCollection::fetchRelatedObjects($nonExistingArticleID) should have returned false" );
        $this->assertFalse(
            eZContentFunctionCollection::fetchRelatedObjectsCount( $nonExistingArticleID, false, true ),
            "eZContentFunctionCollection::fetchRelatedObjectsCount($nonExistingArticleID) should have returned false" );
        $this->assertFalse( eZContentFunctionCollection::fetchReverseRelatedObjects( $nonExistingArticleID, false, true, false, false, false ),
            "eZContentFunctionCollection::fetchReverseRelatedObjects($nonExistingArticleID) should have returned false" );
        $this->assertFalse( eZContentFunctionCollection::fetchReverseRelatedObjectsCount( $nonExistingArticleID, false, true, false ),
            "eZContentFunctionCollection::fetchReverseRelatedObjectsCount($nonExistingArticleID) should have returned false" );
    }
}

?>
