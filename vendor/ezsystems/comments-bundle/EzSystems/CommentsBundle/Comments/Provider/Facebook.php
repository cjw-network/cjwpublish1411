<?php
/**
 * File containing the Facebook comments provider class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace EzSystems\CommentsBundle\Comments\Provider;

use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

class Facebook extends TemplateBasedProvider
{
    const DEFAULT_WIDTH = 470;
    const DEFAULT_NUM_POSTS = 10;
    const DEFAULT_COLOR_SCHEME = 'light';
    const DEFAULT_INCLUDE_SDK = true;

    /**
     * Your Facebook application ID.
     *
     * @var string
     */
    private $appId;

    /**
     * Default width for the comments box.
     *
     * @var int
     */
    private $defaultWidth;

    /**
     * Default number of comments to display.
     *
     * @var int
     */
    private $defaultNumPosts;

    /**
     * Default color scheme to use for the comments box.
     * Only "light" or "dark" are possible.
     *
     * @var string
     */
    private $defaultColorScheme;

    /**
     * Indicates if we need to include Facebook SDK for commenting.
     * If set to false, SDK must be loaded in another way in the page.
     *
     * @var bool
     */
    private $defaultIncludeSDK;

    /**
     * @var \eZ\Publish\API\Repository\LocationService
     */
    private $locationService;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    public function __construct( $appId, array $defaultOptions, LocationService $locationService, RouterInterface $router, EngineInterface $templateEngine = null, $defaultTemplate = null )
    {
        $this->appId = $appId;
        $this->defaultWidth = isset( $defaultOptions['width'] ) ? $defaultOptions['width'] : static::DEFAULT_WIDTH;
        $this->defaultNumPosts = isset( $defaultOptions['num_posts'] ) ? $defaultOptions['num_posts'] : static::DEFAULT_NUM_POSTS;
        $this->defaultColorScheme = isset( $defaultOptions['color_scheme'] ) ? $defaultOptions['color_scheme'] : static::DEFAULT_COLOR_SCHEME;
        $this->defaultIncludeSDK = isset( $defaultOptions['include_sdk'] ) ? $defaultOptions['include_sdk'] : static::DEFAULT_INCLUDE_SDK;
        $this->locationService = $locationService;
        $this->router = $router;

        parent::__construct( $templateEngine, $defaultTemplate );
    }

    /**
     * Renders the comments list.
     * Comment form might also be included.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param array $options
     *
     * @return string
     */
    public function render( Request $request, array $options = array() )
    {
        return $this->doRender(
            $options + array(
                'app_id' => $this->appId,
                'width' => $this->defaultWidth,
                'num_posts' => $this->defaultNumPosts,
                'color_scheme' => $this->defaultColorScheme,
                'include_sdk' => $this->defaultIncludeSDK,
                'url' => $request->getSchemeAndHttpHost() . $request->attributes->get( 'semanticPathinfo', $request->getPathInfo() )
            )
        );
    }

    /**
     * Renders the comments list for a given content.
     * Comment form might also be included
     *
     * @param \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param array $options
     *
     * @return string
     */
    public function renderForContent( ContentInfo $contentInfo, Request $request, array $options = array() )
    {
        $foo = $this->locationService->loadLocation( $contentInfo->mainLocationId );

        return $this->doRender(
            $options + array(
                'app_id' => $this->appId,
                'width' => $this->defaultWidth,
                'num_posts' => $this->defaultNumPosts,
                'color_scheme' => $this->defaultColorScheme,
                'include_sdk' => $this->defaultIncludeSDK,
                'url' => $this->router->generate( $foo, array(), true )
            )
        );
    }
}
