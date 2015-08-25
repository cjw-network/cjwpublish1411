<?php
/**
 * File containing the FacebookTest class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace EzSystems\CommentsBundle\Tests\Provider;

use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use EzSystems\CommentsBundle\Comments\Provider\Facebook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;

class FacebookTest extends TemplateBasedProviderTest
{
    const APP_ID = "123";

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\eZ\Publish\API\Repository\LocationService
     */
    private $locationService;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * Returns the default template for the comments provider.
     * e.g. "disqus.html.twig".
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'facebook.html.twig';
    }

    /**
     * Returns the comments provider to test.
     *
     * @param \Symfony\Component\Templating\EngineInterface $templateEngine
     * @param $defaultTemplate
     *
     * @return \EzSystems\CommentsBundle\Comments\Provider\TemplateBasedProvider
     */
    protected function getCommentsProvider( EngineInterface $templateEngine, $defaultTemplate )
    {
        return new Facebook( static::APP_ID, array(), $this->getLocationService(), $this->getRouter(), $templateEngine, $defaultTemplate );
    }

    /**
     * @return \eZ\Publish\API\Repository\LocationService|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getLocationService()
    {
        if ( !isset( $this->locationService ) )
        {
            $this->locationService = $this->getMock( 'eZ\\Publish\\API\\Repository\\LocationService' );
        }

        return $this->locationService;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Symfony\Component\Routing\RouterInterface
     */
    private function getRouter()
    {
        if ( !isset( $this->router ) )
        {
            $this->router = $this->getMock( 'Symfony\\Component\\Routing\\RouterInterface' );
        }

        return $this->router;
    }

    /**
     * Returns the hash of options that is expected to be injected by the provider into the comments template,
     * given the Request object.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function getExpectedOptions( Request $request )
    {
        return array(
            'app_id' => static::APP_ID,
            'width' => Facebook::DEFAULT_WIDTH,
            'num_posts' => Facebook::DEFAULT_NUM_POSTS,
            'color_scheme' => Facebook::DEFAULT_COLOR_SCHEME,
            'include_sdk' => Facebook::DEFAULT_INCLUDE_SDK,
            'url' => $request->getSchemeAndHttpHost() . $request->attributes->get( 'semanticPathinfo', $request->getPathInfo() )
        );
    }

    /**
     * Returns the hash of options that is expected to be injected by the provider into the comments template,
     * givent the ContentInfo and Request object.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function getExpectedOptionsForContent( ContentInfo $contentInfo, Request $request )
    {
        return array(
            'app_id' => static::APP_ID,
            'width' => Facebook::DEFAULT_WIDTH,
            'num_posts' => Facebook::DEFAULT_NUM_POSTS,
            'color_scheme' => Facebook::DEFAULT_COLOR_SCHEME,
            'include_sdk' => Facebook::DEFAULT_INCLUDE_SDK,
        );
    }

    /**
     * @dataProvider renderForContentTestProvider
     *
     * @param ContentInfo $contentInfo
     * @param Request $request
     * @param array $options Minimal options the provider is supposed to inject into its template
     * @param array $customOptions Custom options injected by higher call (e.g. from the template helper)
     */
    public function testRenderForContent( ContentInfo $contentInfo, Request $request, array $options, array $customOptions = array() )
    {
        parent::testRenderForContent(
            $contentInfo,
            $request,
            array( 'url' => $this->getContentUrl( $contentInfo ) ) + $options,
            $customOptions
        );
    }

    /**
     * @dataProvider renderForContentTestProvider
     *
     * @param ContentInfo $contentInfo
     * @param Request $request
     * @param array $options Minimal options the provider is supposed to inject into its template
     * @param array $customOptions Custom options injected by higher call (e.g. from the template helper)
     */
    public function testRenderForContentTemplateOverride( ContentInfo $contentInfo, Request $request, array $options, array $customOptions = array() )
    {
        parent::testRenderForContentTemplateOverride(
            $contentInfo,
            $request,
            array( 'url' => $this->getContentUrl( $contentInfo ) ) + $options,
            $customOptions
        );
    }

    private function getContentUrl( ContentInfo $contentInfo )
    {
        $mainLocation = $this->getMockBuilder( 'eZ\\Publish\\API\\Repository\\Values\\Content\\Location' )
            ->setConstructorArgs( array( array( 'id' => $contentInfo->mainLocationId ) ) )
            ->getMock();

        $this->getLocationService()
            ->expects( $this->once() )
            ->method( 'loadLocation' )
            ->with( $contentInfo->mainLocationId )
            ->will( $this->returnValue( $mainLocation ) );

        $expectedUrl = "http://ezpublish.dev/content/view/location/$contentInfo->mainLocationId";
        $this->getRouter()
            ->expects( $this->once() )
            ->method( 'generate' )
            ->with( $mainLocation, array(), true )
            ->will( $this->returnValue( $expectedUrl ) );

        return $expectedUrl;
    }
}
