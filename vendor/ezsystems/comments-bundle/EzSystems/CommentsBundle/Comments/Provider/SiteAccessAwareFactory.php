<?php
/**
 * File containing the SiteAccessAwareFactory class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace EzSystems\CommentsBundle\Comments\Provider;

use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class SiteAccessAwareFactory
{
    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    protected $configResolver;

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $templateEngine;

    public function __construct( ConfigResolverInterface $configResolver, EngineInterface $templateEngine )
    {
        $this->configResolver = $configResolver;
        $this->templateEngine = $templateEngine;
    }

    /**
     * @param string $disqusProviderClass
     *
     * @return \EzSystems\CommentsBundle\Comments\ProviderInterface
     */
    public function buildDisqus( $disqusProviderClass )
    {
        /** @var \EzSystems\CommentsBundle\Comments\Provider\Disqus $disqusProvider */
        $disqusProvider = new $disqusProviderClass();
        $disqusProvider->setTemplateEngine( $this->templateEngine );
        $disqusProvider->setDefaultTemplate(
            $this->configResolver->getParameter( 'disqus.default_template', 'ez_comments' )
        );
        $disqusProvider->setShortName( $this->configResolver->getParameter( 'disqus.shortname', 'ez_comments' ) );

        return $disqusProvider;
    }

    /**
     * @param LocationService $locationService
     * @param RouterInterface $router
     *
     * @return \EzSystems\CommentsBundle\Comments\ProviderInterface
     */
    public function buildFacebook( LocationService $locationService, RouterInterface $router )
    {
        $facebookProvider = new Facebook(
            $this->configResolver->getParameter( 'facebook.app_id', 'ez_comments' ),
            array(
                'width' => $this->configResolver->getParameter( 'facebook.width', 'ez_comments' ),
                'num_posts' => $this->configResolver->getParameter( 'facebook.num_posts', 'ez_comments' ),
                'color_scheme' => $this->configResolver->getParameter( 'facebook.color_scheme', 'ez_comments' ),
                'include_sdk' => $this->configResolver->getParameter( 'facebook.include_sdk', 'ez_comments' ),
            ),
            $locationService,
            $router,
            $this->templateEngine,
            $this->configResolver->getParameter( 'facebook.default_template', 'ez_comments' )
        );

        return $facebookProvider;
    }
}
