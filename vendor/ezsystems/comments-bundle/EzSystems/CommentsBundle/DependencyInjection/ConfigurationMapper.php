<?php
/**
 * File containing the ConfigurationMap class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace EzSystems\CommentsBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\HookableConfigurationMapperInterface;

class ConfigurationMapper implements HookableConfigurationMapperInterface
{
    public function mapConfig( array &$scopeSettings, $currentScope, ContextualizerInterface $contextualizer )
    {
        // Common settings
        if ( isset( $scopeSettings['default_provider'] ) )
            $contextualizer->setContextualParameter( 'default_provider', $currentScope, $scopeSettings['default_provider'] );
        if ( isset( $scopeSettings['content_comments'] ) )
        {
            $scopeSettings['content_comments'] = array( 'comments' => $scopeSettings['content_comments'] );
        }

        // Disqus
        if ( isset( $scopeSettings['disqus']['shortname'] ) )
            $contextualizer->setContextualParameter( 'disqus.shortname', $currentScope, $scopeSettings['disqus']['shortname'] );
        if ( isset( $scopeSettings['disqus']['template'] ) )
            $contextualizer->setContextualParameter( 'disqus.default_template', $currentScope, $scopeSettings['disqus']['template'] );

        // Facebook
        if ( isset( $scopeSettings['facebook']['app_id'] ) )
            $contextualizer->setContextualParameter( 'facebook.app_id', $currentScope, $scopeSettings['facebook']['app_id'] );
        if ( isset( $scopeSettings['facebook']['width'] ) )
            $contextualizer->setContextualParameter( 'facebook.width', $currentScope, $scopeSettings['facebook']['width'] );
        if ( isset( $scopeSettings['facebook']['num_posts'] ) )
            $contextualizer->setContextualParameter( 'facebook.num_posts', $currentScope, $scopeSettings['facebook']['num_posts'] );
        if ( isset( $scopeSettings['facebook']['color_scheme'] ) )
            $contextualizer->setContextualParameter( 'facebook.color_scheme', $currentScope, $scopeSettings['facebook']['color_scheme'] );
        if ( isset( $scopeSettings['facebook']['include_sdk'] ) )
            $contextualizer->setContextualParameter( 'facebook.include_sdk', $currentScope, $scopeSettings['facebook']['include_sdk'] );
        if ( isset( $scopeSettings['facebook']['template'] ) )
            $contextualizer->setContextualParameter( 'facebook.default_template', $currentScope, $scopeSettings['facebook']['template'] );
    }

    public function preMap( array $config, ContextualizerInterface $contextualizer )
    {
        // Nothing to do here.
    }

    public function postMap( array $config, ContextualizerInterface $contextualizer )
    {
        $contextualizer->mapConfigArray( 'content_comments', $config, ContextualizerInterface::MERGE_FROM_SECOND_LEVEL );
    }
}
