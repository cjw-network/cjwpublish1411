<?php
/**
 * File containing the EzSystemsCommentsExtensionTest class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace EzSystems\CommentsBundle\Tests\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ConfigResolver;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use EzSystems\CommentsBundle\DependencyInjection\EzSystemsCommentsExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class EzSystemsCommentsExtensionTest extends AbstractExtensionTestCase
{
    private $availableSiteAccesses;

    private $groupsBySiteAccess;

    /**
     * @var \eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ConfigResolver
     */
    private $configResolver;

    protected function setUp()
    {
        parent::setUp();
        $this->availableSiteAccesses = array( 'sa1', 'sa2', 'sa3' );
        ConfigurationProcessor::setAvailableSiteAccesses( $this->availableSiteAccesses );
        $this->groupsBySiteAccess = array(
            'sa2' => array( 'sa_group' ),
            'sa3' => array( 'sa_group' ),
        );
        ConfigurationProcessor::setGroupsBySiteAccess( $this->groupsBySiteAccess );
        $this->configResolver = new ConfigResolver( $this->groupsBySiteAccess, 'ezsettings' );
    }

    protected function getContainerExtensions()
    {
        return array( new EzSystemsCommentsExtension() );
    }

    protected function load( array $configurationValues = array() )
    {
        parent::load( $configurationValues );
        $this->configResolver->setContainer( $this->container );
    }

    public function testGetAlias()
    {
        $extension = new EzSystemsCommentsExtension();
        $this->assertSame( 'ez_comments', $extension->getAlias() );
    }

    public function testNoConfig()
    {
        $this->load();

        foreach ( $this->availableSiteAccesses as $sa )
        {
            $this->assertSame( 'no_comments', $this->configResolver->getParameter( 'default_provider', 'ez_comments', $sa ) );
            $this->assertSame( array(), $this->configResolver->getParameter( 'content_comments', 'ez_comments', $sa ) );
            $this->assertSame( 'EzSystemsCommentsBundle::disqus.html.twig', $this->configResolver->getParameter( 'disqus.default_template', 'ez_comments', $sa ) );
            $this->assertSame( 'EzSystemsCommentsBundle::facebook.html.twig', $this->configResolver->getParameter( 'facebook.default_template', 'ez_comments', $sa ) );
            $this->assertSame( 'light', $this->configResolver->getParameter( 'facebook.color_scheme', 'ez_comments', $sa ) );
            $this->assertTrue( $this->configResolver->getParameter( 'facebook.include_sdk', 'ez_comments', $sa ) );
        }
    }

    public function testDefaultProvider()
    {
        $providerSa1 = 'disqus';
        $providerSaGroup = 'facebook';
        $config = array(
            'system' => array(
                'sa1' => array(
                    'default_provider' => $providerSa1
                ),
                'sa2' => array(
                    'disqus' => array( 'shortname' => 'foo' )
                ),
                'sa_group' => array(
                    'default_provider' => $providerSaGroup
                )
            )
        );
        $this->load( $config );

        $this->assertSame( $providerSa1, $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa1' ) );
        $this->assertSame( $providerSaGroup, $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa2' ) );
        $this->assertSame( $providerSaGroup, $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa3' ) );
    }

    public function testContentComments()
    {
        $providerSa1 = 'disqus';
        $contentCommentsSa1 = array(
            'public_articles' => array(
                'enabled' => true,
                'provider' => 'facebook',
                'match' => array(
                    'Identifier\\ContentType' => array( 'article', 'blog_post' ),
                    'Identifier\\Section' => 'standard',
                ),
                'options' => array( 'foo' => 'bar' )
            ),
            'private_articles' => array(
                'enabled' => true,
                'provider' => 'disqus',
                'match' => array(
                    'Identifier\\ContentType' => array( 'article', 'blog_post' ),
                    'Identifier\\Section' => 'private',
                ),
                'options' => array( 'width' => 470 )
            )
        );
        $expectedContentCommentsSa1 = array( 'comments' => $contentCommentsSa1 );

        $providerSaGroup = 'facebook';
        $contentCommentsSaGroup = array(
            'nights_watch_comments' => array(
                'enabled' => false,
                'provider' => 'raven',
                'match' => array(
                    'Identifier\\ContentType' => array( 'men_request', 'complaints' ),
                ),
            ),
            'cersei_comments' => array(
                'enabled' => true,
                'provider' => 'i_dont_care',
                'match' => array(
                    'Identifier\\ContentType' => array( 'more_wine', 'more_blood' ),
                    'Identifier\\Section' => 'private',
                ),
            )
        );
        $expectedCommentsSaGroup = array(
            'comments' => array(
                'nights_watch_comments' => array(
                    'enabled' => false,
                    'provider' => 'raven',
                    'match' => array(
                        'Identifier\\ContentType' => array( 'men_request', 'complaints' ),
                    ),
                    'options' => array()
                ),
                'cersei_comments' => array(
                    'enabled' => true,
                    'provider' => 'i_dont_care',
                    'match' => array(
                        'Identifier\\ContentType' => array( 'more_wine', 'more_blood' ),
                        'Identifier\\Section' => 'private',
                    ),
                    'options' => array()
                )
            )
        );

        $providerSa2 = 'disqus';

        $contentCommentsSa3 = array(
            'melisandre_comments' => array(
                'enabled' => true,
                'provider' => 'stanis_baratheon',
                'match' => array(
                    'God\Type' => 'fire_fire_FIRE'
                )
            ),
            'cersei_comments' => array(
                'enabled' => false
            ),
            'nights_watch_comments' => array(
                'enabled' => true,
                'provider' => 'raven',
                'match' => array(
                    'Identifier\\ContentType' => array( 'men_request', 'complaints' ),
                )
            )
        );
        $expectedContentCommentsSa3 = array(
            'comments' => array(
                'nights_watch_comments' => array(
                    'enabled' => true,
                    'provider' => 'raven',
                    'match' => array(
                        'Identifier\\ContentType' => array( 'men_request', 'complaints' ),
                    ),
                    'options' => array()
                ),
                'cersei_comments' => array(
                    'enabled' => false,
                    'match' => array(),
                    'options' => array()
                ),
                'melisandre_comments' => array(
                    'enabled' => true,
                    'provider' => 'stanis_baratheon',
                    'match' => array(
                        'God\\Type' => 'fire_fire_FIRE'
                    ),
                    'options' => array()
                )
            )
        );

        $config = array(
            'system' => array(
                'sa1' => array(
                    'default_provider' => $providerSa1,
                    'content_comments' => $contentCommentsSa1,
                ),
                'sa2' => array(
                    'default_provider' => $providerSa2
                ),
                'sa3' => array(
                    'content_comments' => $contentCommentsSa3,
                ),
                'sa_group' => array(
                    'default_provider' => $providerSaGroup,
                    'content_comments' => $contentCommentsSaGroup
                )
            )
        );
        $this->load( $config );

        $this->assertSame( $providerSa1, $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa1' ) );
        $this->assertEquals( $expectedContentCommentsSa1, $this->configResolver->getParameter( 'content_comments', 'ez_comments', 'sa1' ) );

        $this->assertSame( $providerSa2, $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa2' ) );
        $this->assertEquals( $expectedCommentsSaGroup, $this->configResolver->getParameter( 'content_comments', 'ez_comments', 'sa2' ) );

        $this->assertSame( $providerSaGroup, $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa3' ) );
        $this->assertEquals( $expectedContentCommentsSa3, $this->configResolver->getParameter( 'content_comments', 'ez_comments', 'sa3' ) );
    }

    public function testDisqus()
    {
        $shortnameSa1 = 'nights_watch';
        $shortnameSaGroup = 'kings_landing';
        $templateSa1 = 'the_wall.html.twig';
        $defaultTemplate = 'EzSystemsCommentsBundle::disqus.html.twig';
        $config = array(
            'system' => array(
                'sa1' => array(
                    'default_provider' => 'disqus',
                    'disqus' => array(
                        'shortname' => $shortnameSa1,
                        'template' => $templateSa1
                    )
                ),
                'sa_group' => array(
                    'default_provider' => 'disqus',
                    'disqus' => array(
                        'shortname' => $shortnameSaGroup
                    )
                )
            )
        );
        $this->load( $config );

        $this->assertSame( 'disqus', $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa1' ) );
        $this->assertSame( 'disqus', $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa2' ) );
        $this->assertSame( 'disqus', $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa3' ) );
        $this->assertSame( $shortnameSa1, $this->configResolver->getParameter( 'disqus.shortname', 'ez_comments', 'sa1' ) );
        $this->assertSame( $templateSa1, $this->configResolver->getParameter( 'disqus.default_template', 'ez_comments', 'sa1' ) );
        $this->assertSame( $shortnameSaGroup, $this->configResolver->getParameter( 'disqus.shortname', 'ez_comments', 'sa2' ) );
        $this->assertSame( $shortnameSaGroup, $this->configResolver->getParameter( 'disqus.shortname', 'ez_comments', 'sa3' ) );
        $this->assertSame( $defaultTemplate, $this->configResolver->getParameter( 'disqus.default_template', 'ez_comments', 'sa2' ) );
        $this->assertSame( $defaultTemplate, $this->configResolver->getParameter( 'disqus.default_template', 'ez_comments', 'sa3' ) );
    }

    public function testFacebook()
    {
        $defaultWidth = 470;
        $appIdSa1 = 123;
        $colorSchemeSa1 = 'dark';
        $includeSdkSa1 = false;
        $defaultNumPosts = 10;
        $appIdSa2 = 456;
        $numPostsSa2 = 20;
        $includeSdkSa2 = true;
        $widthSa2 = 471;
        $appIdSaGroup = 789;
        $includeSdkSaGroup = false;
        $numPostsSaGroup = 15;
        $defaultTemplate = 'EzSystemsCommentsBundle::facebook.html.twig';
        $templateSa1 = 'tyron_half_face_book.html.twig';
        $templateSa2 = 'cerseis_facebook.html.twig';
        $widthSaGroup = 570;
        $config = array(
            'system' => array(
                'sa1' => array(
                    'default_provider' => 'facebook',
                    'facebook' => array(
                        'app_id' => $appIdSa1,
                        'color_scheme' => $colorSchemeSa1,
                        'include_sdk' => $includeSdkSa1,
                        'template' => $templateSa1
                    )
                ),
                'sa2' => array(
                    'default_provider' => 'disqus',
                    'facebook' => array(
                        'app_id' => $appIdSa2,
                        'num_posts' => $numPostsSa2,
                        'include_sdk' => $includeSdkSa2,
                        'template' => $templateSa2,
                        'width' => $widthSa2
                    )
                ),
                'sa_group' => array(
                    'default_provider' => 'facebook',
                    'facebook' => array(
                        'app_id' => $appIdSaGroup,
                        'include_sdk' => $includeSdkSaGroup,
                        'num_posts' => $numPostsSaGroup,
                        'width' => $widthSaGroup
                    )
                )
            )
        );
        $this->load( $config );

        $this->assertSame( 'facebook', $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa1' ) );
        $this->assertSame( 'disqus', $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa2' ) );
        $this->assertSame( 'facebook', $this->configResolver->getParameter( 'default_provider', 'ez_comments', 'sa3' ) );

        $this->assertSame( $appIdSa1, $this->configResolver->getParameter( 'facebook.app_id', 'ez_comments', 'sa1' ) );
        $this->assertSame( $appIdSa2, $this->configResolver->getParameter( 'facebook.app_id', 'ez_comments', 'sa2' ) );
        $this->assertSame( $appIdSaGroup, $this->configResolver->getParameter( 'facebook.app_id', 'ez_comments', 'sa3' ) );

        $this->assertSame( $colorSchemeSa1, $this->configResolver->getParameter( 'facebook.color_scheme', 'ez_comments', 'sa1' ) );
        $this->assertSame( 'light', $this->configResolver->getParameter( 'facebook.color_scheme', 'ez_comments', 'sa2' ) );
        $this->assertSame( 'light', $this->configResolver->getParameter( 'facebook.color_scheme', 'ez_comments', 'sa3' ) );

        $this->assertSame( $includeSdkSa1, $this->configResolver->getParameter( 'facebook.include_sdk', 'ez_comments', 'sa1' ) );
        $this->assertSame( $includeSdkSa2, $this->configResolver->getParameter( 'facebook.include_sdk', 'ez_comments', 'sa2' ) );
        $this->assertSame( $includeSdkSaGroup, $this->configResolver->getParameter( 'facebook.include_sdk', 'ez_comments', 'sa3' ) );

        $this->assertSame( $templateSa1, $this->configResolver->getParameter( 'facebook.default_template', 'ez_comments', 'sa1' ) );
        $this->assertSame( $templateSa2, $this->configResolver->getParameter( 'facebook.default_template', 'ez_comments', 'sa2' ) );
        $this->assertSame( $defaultTemplate, $this->configResolver->getParameter( 'facebook.default_template', 'ez_comments', 'sa3' ) );

        $this->assertSame( $defaultWidth, $this->configResolver->getParameter( 'facebook.width', 'ez_comments', 'sa1' ) );
        $this->assertSame( $widthSa2, $this->configResolver->getParameter( 'facebook.width', 'ez_comments', 'sa2' ) );
        $this->assertSame( $widthSaGroup, $this->configResolver->getParameter( 'facebook.width', 'ez_comments', 'sa3' ) );

        $this->assertSame( $defaultNumPosts, $this->configResolver->getParameter( 'facebook.num_posts', 'ez_comments', 'sa1' ) );
        $this->assertSame( $numPostsSa2, $this->configResolver->getParameter( 'facebook.num_posts', 'ez_comments', 'sa2' ) );
        $this->assertSame( $numPostsSaGroup, $this->configResolver->getParameter( 'facebook.num_posts', 'ez_comments', 'sa3' ) );
    }
}
