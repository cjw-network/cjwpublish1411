<?php
/**
 * File containing the eZContentObjectRegression class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 * @backupGlobals disabled
 */

class ezpContentRegression extends ezpDatabaseTestCase
{
    protected static $previousUserID;

    public function setUp()
    {
        parent::setUp();
        $currentUser = eZUser::currentUser();
        $anonymousID = eZUser::anonymousId();
        if ( $currentUser->isRegistered() )
        {
            self::$previousUserID = $currentUser->attribute( 'contentobject_id' );
            eZUser::setCurrentlyLoggedInUser( eZUser::fetch( $anonymousID ), $anonymousID );
        }
    }

    public function tearDown()
    {
        eZUser::setCurrentlyLoggedInUser( eZUser::fetch( self::$previousUserID ), self::$previousUserID );
        parent::tearDown();
    }

    /**
     * @group issue18073
     * @link http://issues.ez.no/18073
     */
    public function testUnauthorizedContentByNodeId()
    {
        $this->setExpectedException( 'ezpContentAccessDeniedException' );
        // Let's take content node #5 / object #4 (users) as unauthorized content for anonymous user
        $unauthorizedNodeID = 5;
        $content = ezpContent::fromNodeId( $unauthorizedNodeID );
    }

    /**
     * @group issue18073
     * @link http://issues.ez.no/18073
     */
    public function testUnauthorizedContentByNode()
    {
        $this->setExpectedException( 'ezpContentAccessDeniedException' );
        // Let's take content node #5 / object #4 (users) as unauthorized content for anonymous user
        $unauthorizedNodeID = 5;
        $content = ezpContent::fromNode( eZContentObjectTreeNode::fetch( $unauthorizedNodeID ) );
    }

    /**
     * @group issue18073
     * @link http://issues.ez.no/18073
     */
    public function testUnauthorizedContentByObjectId()
    {
        $this->setExpectedException( 'ezpContentAccessDeniedException' );
        // Let's take content node #5 / object #4 (users) as unauthorized content for anonymous user
        $unauthorizedObjectID = 4;
        $content = ezpContent::fromObjectId( $unauthorizedObjectID );
    }

    /**
     * @group issue18073
     * @link http://issues.ez.no/18073
     */
    public function testUnauthorizedContentByObject()
    {
        $this->setExpectedException( 'ezpContentAccessDeniedException' );
        // Let's take content node #5 / object #4 (users) as unauthorized content for anonymous user
        $unauthorizedObjectID = 4;
        $content = ezpContent::fromObject( eZContentObject::fetch( $unauthorizedObjectID ) );
    }
}
?>
