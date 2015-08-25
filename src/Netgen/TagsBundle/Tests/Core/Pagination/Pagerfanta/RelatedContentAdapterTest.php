<?php

namespace Netgen\TagsBundle\Tests\Core\Pagination\Pagerfanta;
use Netgen\TagsBundle\API\Repository\Values\Tags\Tag;
use Netgen\TagsBundle\API\Repository\TagsService;
use Netgen\TagsBundle\Core\Pagination\Pagerfanta\RelatedContentAdapter;
use eZ\Publish\Core\Repository\Values\Content\Content;
use PHPUnit_Framework_TestCase;

class RelatedContentAdapterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Netgen\TagsBundle\API\Repository\TagsService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $tagsService;

    /**
     * Sets up the test
     */
    protected function setUp()
    {
        parent::setUp();
        $this->tagsService = $this->getMock( 'Netgen\TagsBundle\API\Repository\TagsService' );
    }

    /**
     * Returns the adapter to test.
     *
     * @param \Netgen\TagsBundle\API\Repository\Values\Tags\Tag $tag
     * @param \Netgen\TagsBundle\API\Repository\TagsService $tagsService
     *
     * @return \Netgen\TagsBundle\Core\Pagination\Pagerfanta\RelatedContentAdapter
     */
    protected function getAdapter( Tag $tag, TagsService $tagsService )
    {
        return new RelatedContentAdapter( $tag, $tagsService );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Pagination\Pagerfanta\RelatedContentAdapter::testGetNbResults
     */
    public function testGetNbResults()
    {
        $nbResults = 4;

        $tag = new Tag(
            array(
                'id' => 42
            )
        );

        $this->tagsService
            ->expects( $this->once() )
            ->method( 'getRelatedContentCount' )
            ->with( $this->equalTo( $tag ) )
            ->will( $this->returnValue( $nbResults ) );

        $adapter = $this->getAdapter( $tag, $this->tagsService );
        $this->assertSame( $nbResults, $adapter->getNbResults() );

        // Running a 2nd time to ensure TagsService::getRelatedContentCount() is called only once.
        $this->assertSame( $nbResults, $adapter->getNbResults() );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Pagination\Pagerfanta\RelatedContentAdapter::testGetSlice
     */
    public function testGetSlice()
    {
        $offset = 2;
        $limit = 2;
        $nbResults = 5;

        $tag = new Tag(
            array(
                'id' => 42
            )
        );

        $relatedContent = array(
            new Content(
                array(
                    'internalFields' => array()
                )
            ),
            new Content(
                array(
                    'internalFields' => array()
                )
            )
        );

        $this->tagsService
            ->expects( $this->once() )
            ->method( 'getRelatedContentCount' )
            ->with( $this->equalTo( $tag ) )
            ->will( $this->returnValue( $nbResults ) );

        $this
            ->tagsService
            ->expects( $this->once() )
            ->method( 'getRelatedContent' )
            ->with(
                $this->equalTo( $tag ),
                $this->equalTo( $offset ),
                $this->equalTo( $limit )
            )
            ->will(
                $this->returnValue( $relatedContent )
            );

        $adapter = $this->getAdapter( $tag, $this->tagsService );

        $this->assertSame( $relatedContent, $adapter->getSlice( $offset, $limit ) );
        $this->assertSame( $nbResults, $adapter->getNbResults() );
    }
}
