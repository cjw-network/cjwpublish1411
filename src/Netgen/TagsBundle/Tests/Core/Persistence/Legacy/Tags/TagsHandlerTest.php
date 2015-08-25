<?php

namespace Netgen\TagsBundle\Tests\Core\Persistence\Legacy\Tags;

use eZ\Publish\Core\Persistence\Legacy\Tests\TestCase;
use Netgen\TagsBundle\SPI\Persistence\Tags\Tag;
use Netgen\TagsBundle\SPI\Persistence\Tags\CreateStruct;
use Netgen\TagsBundle\SPI\Persistence\Tags\UpdateStruct;

/**
 * Test case for Tags Handler
 */
class TagsHandlerTest extends TestCase
{
    /**
     * Mocked tags gateway instance
     *
     * @var \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Gateway
     */
    protected $gateway;

    /**
     * Mocked tags mapper instance
     *
     * @param array $mockedMethods
     *
     * @var \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Mapper
     */
    protected $mapper;

    protected function getTagsHandler( array $mockedMethods = array( "updateSubtreeModificationTime" ) )
    {
        return $this->getMock(
            "Netgen\\TagsBundle\\Core\\Persistence\\Legacy\\Tags\\Handler",
            $mockedMethods,
            array(
                $this->gateway = $this->getMock( "Netgen\\TagsBundle\\Core\\Persistence\\Legacy\\Tags\\Gateway" ),
                $this->mapper = $this->getMock( "Netgen\\TagsBundle\\Core\\Persistence\\Legacy\\Tags\\Mapper" )
            )
        );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::load
     */
    public function testLoad()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getBasicTagData" )
            ->with( 42 )
            ->will(
                $this->returnValue(
                    array(
                        "id" => 42,
                    )
                )
            );

        $this->mapper
            ->expects( $this->once() )
            ->method( "createTagFromRow" )
            ->with( array( "id" => 42 ) )
            ->will( $this->returnValue( new Tag( array( "id" => 42 ) ) ) );

        $tag = $handler->load( 42 );

        $this->assertInstanceOf(
            "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
            $tag
        );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::loadByRemoteId
     */
    public function testLoadByRemoteId()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getBasicTagDataByRemoteId" )
            ->with( "abcdef" )
            ->will(
                $this->returnValue(
                    array(
                        "remote_id" => "abcdef",
                    )
                )
            );

        $this->mapper
            ->expects( $this->once() )
            ->method( "createTagFromRow" )
            ->with( array( "remote_id" => "abcdef" ) )
            ->will( $this->returnValue( new Tag( array( "remoteId" => "abcdef" ) ) ) );

        $tag = $handler->loadByRemoteId( "abcdef" );

        $this->assertInstanceOf(
            "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
            $tag
        );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::loadByUrl
     */
    public function testLoadByUrl()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getBasicTagDataByUrl" )
            ->with( "ez+publish/extensions/eztags" )
            ->will(
                $this->returnValue(
                    array(
                        "id" => "40",
                    )
                )
            );

        $this->mapper
            ->expects( $this->once() )
            ->method( "createTagFromRow" )
            ->with( array( "id" => "40" ) )
            ->will( $this->returnValue( new Tag( array( "id" => "40" ) ) ) );

        $tag = $handler->loadByUrl( "ez+publish/extensions/eztags" );

        $this->assertInstanceOf(
            "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
            $tag
        );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::loadChildren
     */
    public function testLoadChildren()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getChildren" )
            ->with( 42 )
            ->will(
                $this->returnValue(
                    array(
                        array(
                            "id" => 43,
                        ),
                        array(
                            "id" => 44,
                        ),
                        array(
                            "id" => 45,
                        )
                    )
                )
            );

        $this->mapper
            ->expects( $this->once() )
            ->method( "createTagsFromRows" )
            ->with(
                array(
                    array( "id" => 43 ),
                    array( "id" => 44 ),
                    array( "id" => 45 )
                )
            )
            ->will(
                $this->returnValue(
                    array(
                        new Tag( array( "id" => 43 ) ),
                        new Tag( array( "id" => 44 ) ),
                        new Tag( array( "id" => 45 ) )
                    )
                )
            );

        $tags = $handler->loadChildren( 42 );

        $this->assertCount( 3, $tags );

        foreach ( $tags as $tag )
        {
            $this->assertInstanceOf(
                "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
                $tag
            );
        }
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::getChildrenCount
     */
    public function testGetChildrenCount()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getChildrenCount" )
            ->with( 42 )
            ->will( $this->returnValue( 3 ) );

        $tagsCount = $handler->getChildrenCount( 42 );

        $this->assertEquals( 3, $tagsCount );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::getTagsByKeyword
     */
    public function testGetTagsByKeyword()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getTagsByKeyword" )
            ->with( "eztags" )
            ->will(
                $this->returnValue(
                    array(
                        array(
                            "keyword" => "eztags",
                        ),
                        array(
                            "keyword" => "eztags",
                        )
                    )
                )
            );

        $this->mapper
            ->expects( $this->once() )
            ->method( "createTagsFromRows" )
            ->with(
                array(
                    array( "keyword" => "eztags" ),
                    array( "keyword" => "eztags" )
                )
            )
            ->will(
                $this->returnValue(
                    array(
                        new Tag( array( "keyword" => "eztags" ) ),
                        new Tag( array( "keyword" => "eztags" ) )
                    )
                )
            );

        $tags = $handler->loadTagsByKeyword( "eztags" );

        $this->assertCount( 2, $tags );

        foreach ( $tags as $tag )
        {
            $this->assertInstanceOf(
                "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
                $tag
            );
        }
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::getTagsByKeywordCount
     */
    public function testGetTagsByKeywordCount()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getTagsByKeywordCount" )
            ->with( "eztags" )
            ->will( $this->returnValue( 2 ) );

        $tagsCount = $handler->getTagsByKeywordCount( "eztags" );

        $this->assertEquals( 2, $tagsCount );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::loadSynonyms
     */
    public function testLoadSynonyms()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getSynonyms" )
            ->with( 42 )
            ->will(
                $this->returnValue(
                    array(
                        array(
                            "id" => 43,
                        ),
                        array(
                            "id" => 44,
                        ),
                        array(
                            "id" => 45,
                        )
                    )
                )
            );

        $this->mapper
            ->expects( $this->once() )
            ->method( "createTagsFromRows" )
            ->with(
                array(
                    array( "id" => 43 ),
                    array( "id" => 44 ),
                    array( "id" => 45 )
                )
            )
            ->will(
                $this->returnValue(
                    array(
                        new Tag( array( "id" => 43 ) ),
                        new Tag( array( "id" => 44 ) ),
                        new Tag( array( "id" => 45 ) )
                    )
                )
            );

        $tags = $handler->loadSynonyms( 42 );

        $this->assertCount( 3, $tags );

        foreach ( $tags as $tag )
        {
            $this->assertInstanceOf(
                "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
                $tag
            );
        }
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::getSynonymCount
     */
    public function testGetSynonymCount()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getSynonymCount" )
            ->with( 42 )
            ->will( $this->returnValue( 3 ) );

        $tagsCount = $handler->getSynonymCount( 42 );

        $this->assertEquals( 3, $tagsCount );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::loadRelatedContentIds
     */
    public function testLoadRelatedContentIds()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getRelatedContentIds" )
            ->with( 42 )
            ->will( $this->returnValue( array( 43, 44, 45 ) ) );

        $contentIds = $handler->loadRelatedContentIds( 42 );

        $this->assertEquals( array( 43, 44, 45 ), $contentIds );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::getRelatedContentCount
     */
    public function testGetRelatedContentCount()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getRelatedContentCount" )
            ->with( 42 )
            ->will( $this->returnValue( 3 ) );

        $tagsCount = $handler->getRelatedContentCount( 42 );

        $this->assertEquals( 3, $tagsCount );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::create
     */
    public function testCreate()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getBasicTagData" )
            ->with( 21 )
            ->will(
                $this->returnValue(
                    array(
                        "id" => 21,
                        "depth" => 2,
                        "path_string" => "/1/2/",
                    )
                )
            );

        $this->gateway
            ->expects( $this->once() )
            ->method( "create" )
            ->with(
                new CreateStruct(
                    array(
                        "parentTagId" => 21,
                        "keyword" => "New tag",
                        "remoteId" => "123456abcdef"
                    )
                ),
                array(
                    "id" => 21,
                    "depth" => 2,
                    "path_string" => "/1/2/",
                )
            )
            ->will(
                $this->returnValue(
                    new Tag(
                        array(
                            "id" => 95,
                            "parentTagId" => 21,
                            "mainTagId" => 0,
                            "keyword" => "New tag",
                            "depth" => 3,
                            "pathString" => "/1/2/95/",
                            "remoteId" => "123456abcdef"
                        )
                    )
                )
            );

        $tag = $handler->create(
            new CreateStruct(
                array(
                    "parentTagId" => 21,
                    "keyword" => "New tag",
                    "remoteId" => "123456abcdef"
                )
            )
        );

        $this->assertInstanceOf(
            "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
            $tag
        );

        $this->assertPropertiesCorrect(
            array(
                "id" => 95,
                "parentTagId" => 21,
                "keyword" => "New tag",
                "remoteId" => "123456abcdef"
            ),
            $tag
        );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::update
     */
    public function testUpdate()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "update" )
            ->with(
                new UpdateStruct(
                    array(
                        "keyword" => "Updated tag",
                        "remoteId" => "123456abcdef"
                    )
                ),
                40
            );

        $this->gateway
            ->expects( $this->any() )
            ->method( "getBasicTagData" )
            ->with( 40 )
            ->will(
                $this->returnValue(
                    array(
                        "id" => 40,
                        "keyword" => "Updated tag",
                        "remote_id" => "123456abcdef"
                    )
                )
            );

        $this->mapper
            ->expects( $this->any() )
            ->method( "createTagFromRow" )
            ->with(
                array(
                    "id" => 40,
                    "keyword" => "Updated tag",
                    "remote_id" => "123456abcdef"
                )
            )
            ->will(
                $this->returnValue(
                    new Tag(
                        array(
                            "id" => 40,
                            "keyword" => "Updated tag",
                            "remoteId" => "123456abcdef"
                        )
                    )
                )
            );

        $tag = $handler->update(
            new UpdateStruct(
                array(
                    "keyword" => "Updated tag",
                    "remoteId" => "123456abcdef"
                )
            ),
            40
        );

        $this->assertInstanceOf(
            "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
            $tag
        );

        $this->assertPropertiesCorrect(
            array(
                "keyword" => "Updated tag",
                "remoteId" => "123456abcdef"
            ),
            $tag
        );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::addSynonym
     */
    public function testAddSynonym()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getBasicTagData" )
            ->with( 21 )
            ->will(
                $this->returnValue(
                    array(
                        "id" => 21,
                        "parent_id" => 1,
                        "depth" => 2,
                        "path_string" => "/1/21/",
                    )
                )
            );

        $this->gateway
            ->expects( $this->once() )
            ->method( "createSynonym" )
            ->with(
                "New synonym",
                array(
                    "id" => 21,
                    "parent_id" => 1,
                    "depth" => 2,
                    "path_string" => "/1/21/",
                )
            )
            ->will(
                $this->returnValue(
                    new Tag(
                        array(
                            "id" => 95,
                            "parentTagId" => 1,
                            "mainTagId" => 21,
                            "keyword" => "New synonym",
                            "depth" => 2,
                            "pathString" => "/1/95/"
                        )
                    )
                )
            );

        $this->mapper
            ->expects( $this->any() )
            ->method( "createTagFromRow" )
            ->with(
                array(
                    "id" => 21,
                    "parent_id" => 1,
                    "depth" => 2,
                    "path_string" => "/1/21/",
                )
            )
            ->will(
                $this->returnValue(
                    new Tag(
                        array(
                            "id" => 21,
                            "parentTagId" => 1,
                            "depth" => 2,
                            "pathString" => "/1/21/"
                        )
                    )
                )
            );

        $tag = $handler->addSynonym( 21, "New synonym" );

        $this->assertInstanceOf(
            "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
            $tag
        );

        $this->assertPropertiesCorrect(
            array(
                "id" => 95,
                "parentTagId" => 1,
                "mainTagId" => 21,
                "keyword" => "New synonym",
                "depth" => 2,
                "pathString" => "/1/95/"
            ),
            $tag
        );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::convertToSynonym
     */
    public function testConvertToSynonym()
    {
        $handler = $this->getTagsHandler();

        $tagData = array(
            "id" => 16,
            "parent_id" => 0
        );

        $mainTagData = array(
            "id" => 66
        );

        $synonyms = array(
            array(
                "id" => 95
            ),
            array(
                "id" => 96
            )
        );

        $this->gateway
            ->expects( $this->at( 0 ) )
            ->method( "getBasicTagData" )
            ->with( 16 )
            ->will( $this->returnValue( $tagData ) );

        $this->gateway
            ->expects( $this->at( 1 ) )
            ->method( "getBasicTagData" )
            ->with( 66 )
            ->will( $this->returnValue( $mainTagData ) );

        $this->gateway
            ->expects( $this->at( 2 ) )
            ->method( "getSynonyms" )
            ->with( 16 )
            ->will( $this->returnValue( $synonyms ) );

        foreach ( $synonyms as $index => $synonym )
        {
            $this->gateway
                ->expects( $this->at( $index + 3 ) )
                ->method( "moveSynonym" )
                ->with( $synonym["id"], $mainTagData );
        }

        $this->gateway
            ->expects( $this->once() )
            ->method( "convertToSynonym" )
            ->with( 16, $mainTagData );

        $this->gateway
            ->expects( $this->at( 4 + count( $synonyms ) ) )
            ->method( "getBasicTagData" )
            ->with( 16 )
            ->will( $this->returnValue( $tagData ) );

        $this->mapper
            ->expects( $this->at( 0 ) )
            ->method( "createTagFromRow" )
            ->with( $tagData )
            ->will( $this->returnValue( new Tag( array( "id" => 16 ) ) ) );

        $synonym = $handler->convertToSynonym( 16, 66 );

        $this->assertInstanceOf(
            "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
            $synonym
        );

        $this->assertPropertiesCorrect(
            array(
                "id" => 16
            ),
            $synonym
        );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::merge
     */
    public function testMerge()
    {
        $handler = $this->getTagsHandler( array( "loadSynonyms", "updateSubtreeModificationTime" ) );

        $this->gateway
            ->expects( $this->at( 0 ) )
            ->method( "getBasicTagData" )
            ->with( 40 )
            ->will(
                $this->returnValue(
                    array(
                        "id" => 40,
                        "parent_id" => 7
                    )
                )
            );

        $this->gateway
            ->expects( $this->at( 1 ) )
            ->method( "getBasicTagData" )
            ->with( 42 )
            ->will(
                $this->returnValue(
                    array(
                        "id" => 42,
                    )
                )
            );

        $tags = array(
            new Tag( array( "id" => 50 ) ),
            new Tag( array( "id" => 51 ) )
        );

        $handler
            ->expects( $this->once() )
            ->method( "loadSynonyms" )
            ->with( 40 )
            ->will(
                $this->returnValue( $tags )
            );

        array_push( $tags, new Tag( array( "id" => 40 ) ) );

        foreach ( $tags as $index => $tag )
        {
            $this->gateway
                ->expects( $this->at( ( $index + 1 ) * 2 ) )
                ->method( "transferTagAttributeLinks" )
                ->with( $tag->id, 42 );

            $this->gateway
                ->expects( $this->at( ( $index + 1 ) * 2 + 1 ) )
                ->method( "deleteTag" )
                ->with( $tag->id );
        }

        $handler->merge( 40, 42 );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::copySubtree
     */
    public function testCopySubtree()
    {
        $this->markTestIncomplete( "@TODO: Implement test for copySubtree" );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::moveSubtree
     */
    public function testMoveSubtree()
    {
        $handler = $this->getTagsHandler();

        $sourceData = array(
            "id" => 42,
            "parent_id" => 21,
            "depth" => 3,
            "path_string" => "/1/21/42/"
        );

        $destinationData = array(
            "id" => 66,
            "parent_id" => 21,
            "path_string" => "/1/21/66/",
        );

        $movedData = array(
            "id" => 42,
            "parent_id" => 66,
            "depth" => 4,
            "path_string" => "/1/21/66/42/",
            "modified" => 12345
        );

        $this->gateway
            ->expects( $this->at( 0 ) )
            ->method( "getBasicTagData" )
            ->with( 42 )
            ->will( $this->returnValue( $sourceData ) );

        $this->gateway
            ->expects( $this->at( 1 ) )
            ->method( "getBasicTagData" )
            ->with( 66 )
            ->will( $this->returnValue( $destinationData ) );

        $this->gateway
            ->expects( $this->once() )
            ->method( "moveSubtree" )
            ->with( $sourceData, $destinationData )
            ->will( $this->returnValue( $movedData ) );

        $this->mapper
            ->expects( $this->once() )
            ->method( "createTagFromRow" )
            ->with( $movedData )
            ->will(
                $this->returnValue(
                    new Tag(
                        array(
                            "id" => $movedData["id"],
                            "parentTagId" => $movedData["parent_id"],
                            "depth" => $movedData["depth"],
                            "pathString" => $movedData["path_string"],
                            "modificationDate" => $movedData["modified"]
                        )
                    )
                )
            );

        $movedTag = $handler->moveSubtree( 42, 66 );

        $this->assertInstanceOf(
            "Netgen\\TagsBundle\\SPI\\Persistence\\Tags\\Tag",
            $movedTag
        );

        $this->assertPropertiesCorrect(
            array(
                "id" => $movedData["id"],
                "parentTagId" => $movedData["parent_id"],
                "depth" => $movedData["depth"],
                "pathString" => $movedData["path_string"],
                "modificationDate" => $movedData["modified"]
            ),
            $movedTag
        );
    }

    /**
     * @covers \Netgen\TagsBundle\Core\Persistence\Legacy\Tags\Handler::deleteTag
     */
    public function testDeleteTag()
    {
        $handler = $this->getTagsHandler();

        $this->gateway
            ->expects( $this->once() )
            ->method( "getBasicTagData" )
            ->with( 40 )
            ->will(
                $this->returnValue(
                    array(
                        "id" => 40,
                    )
                )
            );

        $this->mapper
            ->expects( $this->once() )
            ->method( "createTagFromRow" )
            ->with( array( "id" => 40 ) )
            ->will( $this->returnValue( new Tag( array( "id" => 40 ) ) ) );

        $this->gateway
            ->expects( $this->once() )
            ->method( "deleteTag" )
            ->with( 40 );

        $handler->deleteTag( 40 );
    }
}
