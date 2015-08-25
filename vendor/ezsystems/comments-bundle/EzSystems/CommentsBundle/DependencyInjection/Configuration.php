<?php
/**
 * File containing the Configuration class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace EzSystems\CommentsBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends SiteAccessConfiguration
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root( 'ez_comments' );

        $systemNode = $this->generateScopeBaseNode( $rootNode );
        $this->addCommonSettings( $systemNode );
        $this->addDisqusSettings( $systemNode );
        $this->addFacebookSettings( $systemNode );

        return $treeBuilder;
    }

    private function addCommonSettings( NodeBuilder $nodeBuilder )
    {
        $nodeBuilder
            ->scalarNode( 'default_provider' )
                ->info( 'Comments provider you want to use by default (e.g. "disqus").' )
            ->end()
            ->arrayNode( 'content_comments' )
                ->info( 'Rules for comments on Content objects. If none provided, commenting will be allowed for any type of content.' )
                ->example(
                    array(
                        'public_articles' => array(
                            'enabled' => true,
                            'provider' => 'facebook',
                            'match' => array(
                                'Identifier\\ContentType' => array( 'article', 'blog_post' ),
                                'Identifier\\Section' => 'standard',
                            )
                        ),
                        'private_articles' => array(
                            'enabled' => true,
                            'provider' => 'disqus',
                            'match' => array(
                                'Identifier\\ContentType' => array( 'article', 'blog_post' ),
                                'Identifier\\Section' => 'private',
                            )
                        )
                    )
                )
                ->useAttributeAsKey( "my_comment_ruleset" )
                ->prototype( "array" )
                    ->normalizeKeys( false )
                    ->children()
                        ->booleanNode( "enabled" )->info( "Indicates if comments are enabled or not. Default is true" )->end()
                        ->scalarNode( "provider" )->info( "Provider to use. Default is configured default_provider" )->end()
                        ->arrayNode( "options" )
                            ->info( 'Provider specific options. See available options for your provider.' )
                            ->prototype( 'variable' )->end()
                        ->end()
                        ->arrayNode( "match" )
                            ->info( 'Condition matchers configuration. You can use the same matchers as for selecting content view templates.' )
                            ->example( array( 'Identifier\\Contentype' => array( 'article', 'blog_post' ) ) )
                            ->useAttributeAsKey( "matcher" )
                            ->prototype( "variable" )->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    private function addDisqusSettings( NodeBuilder $nodeBuilder )
    {
        $nodeBuilder
            ->arrayNode( 'disqus' )
                ->children()
                    ->scalarNode( 'shortname' )->isRequired()->info( 'Disqus "shortname"' )->end()
                    ->scalarNode( 'template' )->info( 'Template to use, overriding the built-in one.' )->end()
                ->end()
            ->end();
    }

    private function addFacebookSettings( NodeBuilder $nodeBuilder )
    {
        $nodeBuilder
            ->arrayNode( 'facebook' )
                ->children()
                    ->scalarNode( 'app_id' )->isRequired()->info( 'Facebook application ID' )->end()
                    ->scalarNode( 'width' )->info( 'Width for the comments box (default is 470)' )->end()
                    ->scalarNode( 'num_posts' )->info( 'Number of comments to display (default is 10)' )->end()
                    ->enumNode( 'color_scheme' )->info( 'Color scheme to use (can be "light" or "dark"). Default is "light"' )->values( array( 'light', 'dark' ) )->end()
                    ->booleanNode( 'include_sdk' )->info( 'Whether to include Facebook JS SDK with the comments rendering. If set to false, you must include it on your own. Default is true.' )->end()
                    ->scalarNode( 'template' )->info( 'Template to use, overriding the built-in one.' )->end()
                ->end()
            ->end();
    }
}
