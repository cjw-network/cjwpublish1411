<?php
/**
 * File containing the TemplateBasedProvider class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace EzSystems\CommentsBundle\Comments\Provider;

use EzSystems\CommentsBundle\Comments\ProviderInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Base class for comments providers that are based on a template.
 */
abstract class TemplateBasedProvider implements ProviderInterface
{
    /**
     * Template to use by default to render Disqus thread.
     *
     * @var string
     */
    private $defaultTemplate;

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    private $templateEngine;

    public function __construct( EngineInterface $templateEngine = null, $defaultTemplate = null )
    {
        $this->templateEngine = $templateEngine;
        $this->defaultTemplate = $defaultTemplate;
    }

    /**
     * Sets default template to use.
     * Must be supported by the template engine.
     *
     * @param string $defaultTemplate
     */
    public function setDefaultTemplate( $defaultTemplate )
    {
        $this->defaultTemplate = $defaultTemplate;
    }

    /**
     * @return string
     */
    public function getDefaultTemplate()
    {
        return $this->defaultTemplate;
    }

    /**
     * @param EngineInterface $templateEngine
     */
    public function setTemplateEngine( EngineInterface $templateEngine )
    {
        $this->templateEngine = $templateEngine;
    }

    /**
     * @return \Symfony\Component\Templating\EngineInterface
     */
    public function getTemplateEngine()
    {
        return $this->templateEngine;
    }

    /**
     * Renders the template with provided options.
     * "template" option allows to override the default template for rendering.
     *
     * @param array $options
     * @return string
     */
    protected function doRender( array $options )
    {
        $template = isset( $options['template'] ) ? $options['template'] : $this->getDefaultTemplate();
        unset( $options['template'] );

        return $this->templateEngine->render( $template, $options );
    }
}
