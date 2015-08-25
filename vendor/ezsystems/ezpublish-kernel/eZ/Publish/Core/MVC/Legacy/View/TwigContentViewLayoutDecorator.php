<?php
/**
 * File containing the TwigLayoutDecorator class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\MVC\Legacy\View;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Symfony\View\ContentViewInterface;
use eZ\Publish\Core\MVC\Symfony\View\ContentView;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use Twig_Environment;

class TwigContentViewLayoutDecorator implements ContentViewInterface
{
    /**
     * @var \eZ\Publish\Core\MVC\Symfony\View\ContentView
     */
    protected $contentView;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    protected $options;

    /**
     * @var array
     */
    protected $configHash;

    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;

    public function __construct( Twig_Environment $twig, array $options, ConfigResolverInterface $configResolver )
    {
        $this->twig = $twig;
        $this->options = $options + array( 'contentBlockName' => 'content' );
        $this->configResolver = $configResolver;
    }

    /**
     * Injects the content view object to decorate.
     *
     * @param \eZ\Publish\Core\MVC\Symfony\View\ContentView $contentView
     */
    public function setContentView( ContentView $contentView )
    {
        $this->contentView = $contentView;
    }

    /**
     * Sets $templateIdentifier to the content view.
     * This decorator only supports closures.
     *
     * Must throw a \eZ\Publish\Core\Base\Exceptions\InvalidArgumentType exception if $templateIdentifier is invalid.
     *
     * @param \Closure $templateIdentifier
     *
     * @throws \eZ\Publish\Core\Base\Exceptions\InvalidArgumentType
     */
    public function setTemplateIdentifier( $templateIdentifier )
    {
        if ( !$templateIdentifier instanceof \Closure )
            throw new InvalidArgumentType( 'templateIdentifier', '\\Closure', $templateIdentifier );

        $this->contentView->setTemplateIdentifier( $templateIdentifier );
    }

    /**
     * Returns the registered template identifier.
     *
     * @throws \RuntimeException
     *
     * @return \Closure
     */
    public function getTemplateIdentifier()
    {
        $options = $this->options;
        $contentView = $this->contentView;
        $twig = $this->twig;
        $layout = $this->configResolver->getParameter( 'view_default_layout', 'ezpublish_legacy' );

        return function ( array $params ) use ( $options, $contentView, $twig, $layout )
        {
            $contentViewClosure = $contentView->getTemplateIdentifier();
            if ( isset( $params['noLayout'] ) && $params['noLayout'] )
            {
                $layout = $options['viewbaseLayout'];
            }
            $twigContentTemplate = <<<EOT
{% extends "{$layout}" %}

{% block {$options['contentBlockName']} %}
{{ viewResult|raw }}
{% endblock %}
EOT;
            return $twig->render(
                $twigContentTemplate,
                $params + array(
                    'viewResult' => $contentViewClosure( $params )
                )
            );
        };
    }

    /**
     * Sets $parameters that will later be injected to the template/closure.
     * If some parameters were already present, $parameters will replace them.
     *
     * @param array $parameters Hash of parameters
     */
    public function setParameters( array $parameters )
    {
        $this->contentView->setParameters( $parameters );
    }

    /**
     * Adds a hash of parameters to the existing parameters.
     *
     * @param array $parameters
     */
    public function addParameters( array $parameters )
    {
        $this->contentView->addParameters( $parameters );
    }

    /**
     * Returns registered parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->contentView->getParameters();
    }

    /**
     * Checks if $parameterName exists.
     *
     * @param string $parameterName
     *
     * @return boolean
     */
    public function hasParameter( $parameterName )
    {
        return $this->contentView->hasParameter( $parameterName );
    }

    /**
     * Returns parameter value by $parameterName.
     * Throws an \InvalidArgumentException if $parameterName is not set.
     *
     * @param string $parameterName
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function getParameter( $parameterName )
    {
        return $this->contentView->getParameter( $parameterName );
    }

    /**
     * Injects the config hash that was used to match and generate the current view.
     * Typically, the hash would have as keys:
     *  - template : The template that has been matched
     *  - match : The matching configuration, including the matcher "identifier" and what has been passed to it.
     *  - matcher : The matcher object
     *
     * @param array $config
     */
    public function setConfigHash( array $config )
    {
        $this->configHash = $config;
    }

    /**
     * Returns the config hash.
     *
     * @return array|null
     */
    public function getConfigHash()
    {
        return $this->configHash;
    }
}
