<?php
/**
 * File containing the CommentsRenderer class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace EzSystems\CommentsBundle\Comments;

use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Symfony\Matcher\MatcherFactoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;

class CommentsRenderer implements ProviderInterface, ContentAuthorizerInterface
{
    /**
     * @var \eZ\Publish\Core\MVC\Symfony\Matcher\MatcherFactoryInterface
     */
    private $matcherFactory;

    /**
     * Comments providers, indexed by their label.
     *
     * @var ProviderInterface[]
     */
    private $providers;

    /**
     * @var string
     */
    private $defaultProvider;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \eZ\Publish\Core\MVC\Symfony\Matcher\MatcherFactoryInterface $matcherFactory
     * @param \eZ\Publish\Core\MVC\ConfigResolverInterface $configResolver
     * @param ProviderInterface[] Comments providers, indexed by their label.
     * @param string|null $defaultProvider Label of provider to use by default. If not provided, the first entry in $providers will be used.
     */
    public function __construct( MatcherFactoryInterface $matcherFactory, ConfigResolverInterface $configResolver, array $providers = array(), $defaultProvider = null )
    {
        $this->matcherFactory = $matcherFactory;
        $this->providers = $providers;
        $this->setDefaultProviderLabel(
            $defaultProvider ?: $configResolver->getParameter( 'default_provider', 'ez_comments' )
        );
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger( LoggerInterface $logger )
    {
        $this->logger = $logger;
    }

    /**
     * Sets the provider to use by default.
     *
     * @param string $defaultProvider Label of the provider to use.
     */
    public function setDefaultProviderLabel( $defaultProvider )
    {
        $this->defaultProvider = $defaultProvider;
    }

    /**
     * Returns the label of the default provider.
     *
     * @return null|string
     */
    public function getDefaultProviderLabel()
    {
        return $this->defaultProvider;
    }

    /**
     * Returns the default provider.
     * If no default provider is set, the first one will be returned.
     *
     * @return ProviderInterface
     */
    public function getDefaultProvider()
    {
        if ( isset( $this->defaultProvider ) )
        {
            return $this->getProvider( $this->defaultProvider );
        }

        $providerLabels = array_keys( $this->providers );
        return $this->providers[$providerLabels[0]];
    }

    /**
     * @param ProviderInterface $provider
     * @param string $label
     */
    public function addProvider( ProviderInterface $provider, $label )
    {
        $this->providers[$label] = $provider;
    }

    /**
     * @param string $label
     *
     * @return bool
     */
    public function hasProvider( $label )
    {
        return isset( $this->providers[$label] );
    }

    /**
     * Retrieves a comments provider by its label
     *
     * @param $label
     *
     * @return ProviderInterface
     *
     * @throws \InvalidArgumentException
     */
    public function getProvider( $label )
    {
        if ( !isset( $this->providers[$label] ) )
        {
            throw new InvalidArgumentException( "Unknown comments provider '$label'" );
        }

        return $this->providers[$label];
    }

    /**
     * Returns all available providers
     *
     * @return ProviderInterface[]
     */
    public function getAllProviders()
    {
        return $this->providers;
    }

    /**
     * Renders the comments list.
     * Comment form might also be included.
     *
     * The default provider will be used unless one is specified in $options (with key 'provider')
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param array $options
     *
     * @return string
     */
    public function render( Request $request, array $options = array() )
    {
        $provider = isset( $options['provider'] ) ? $this->getProvider( $options['provider'] ) : $this->getDefaultProvider();
        unset( $options['provider'] );

        return $provider->render( $request, $options );
    }

    /**
     * Renders the comments list for a given content.
     * Comment form might also be included
     *
     * @param \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param array $options
     *
     * @return mixed
     */
    public function renderForContent( ContentInfo $contentInfo, Request $request, array $options = array() )
    {
        $commentsConfig = $this->getCommentsConfig( $contentInfo );
        if ( isset( $commentsConfig['enabled'] ) && $commentsConfig['enabled'] === false )
        {
            if ( $this->logger )
                $this->logger->debug( "Commenting is specifically disabled for content #$contentInfo->id" );

            return;
        }

        /*
         * Order of precedence for provider is:
         * 1. $options['provider'] => specified directly.
         * 2. $commentConfig['provider'] => configured provider for given content.
         * 3. Defaut provider.
         */
        $providerLabel = $this->defaultProvider;
        if ( isset( $options['provider'] ) )
            $providerLabel = $options['provider'];
        else if ( isset( $commentsConfig['provider'] ) )
            $providerLabel = $commentsConfig['provider'];
        $provider = $this->getProvider( $providerLabel );
        unset( $options['provider'] );

        // Merge configured options with explicitly passed options.
        // Explicit options always have precedence.
        $options = isset( $commentsConfig['options'] ) ? $options + $commentsConfig['options'] : $options;
        return $provider->renderForContent( $contentInfo, $request, $options );
    }

    /**
     * Returns true if it comments can be appended to a content, based on its ContentInfo.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo
     *
     * @return bool
     */
    public function canCommentContent( ContentInfo $contentInfo )
    {
        $commentConfig = $this->getCommentsConfig( $contentInfo );
        return !empty( $commentConfig['enabled'] );
    }

    /**
     * @param \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo
     *
     * @note Matched config is cached in memory by underlying matcher factory.
     *
     * @return array|null
     */
    private function getCommentsConfig( ContentInfo $contentInfo )
    {
        return $this->matcherFactory->match( $contentInfo, 'comments' );
    }
}
