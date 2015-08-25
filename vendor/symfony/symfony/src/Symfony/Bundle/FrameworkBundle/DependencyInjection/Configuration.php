<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * FrameworkExtension configuration structure.
 *
 * @author Jeremy Mikola <jmikola@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('framework');

        $rootNode
            ->children()
                ->scalarNode('secret')->end()
                ->scalarNode('http_method_override')
                    ->info("Set true to enable support for the '_method' request parameter to determine the intended HTTP method on POST requests. Note: When using the HttpCache, you need to call the method in your front controller instead")
                    ->defaultTrue()
                ->end()
                ->arrayNode('trusted_proxies')
                    ->beforeNormalization()
                        ->ifTrue(function ($v) { return !is_array($v) && null !== $v; })
                        ->then(function ($v) { return is_bool($v) ? array() : preg_split('/\s*,\s*/', $v); })
                    ->end()
                    ->prototype('scalar')
                        ->validate()
                            ->ifTrue(function ($v) {
                                if (empty($v)) {
                                    return false;
                                }

                                if (false !== strpos($v, '/')) {
                                    list($v, $mask) = explode('/', $v, 2);

                                    if (strcmp($mask, (int) $mask) || $mask < 1 || $mask > (false !== strpos($v, ':') ? 128 : 32)) {
                                        return true;
                                    }
                                }

                                return !filter_var($v, FILTER_VALIDATE_IP);
                            })
                            ->thenInvalid('Invalid proxy IP "%s"')
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('ide')->defaultNull()->end()
                ->booleanNode('test')->end()
                ->scalarNode('default_locale')->defaultValue('en')->end()
                ->arrayNode('trusted_hosts')
                    ->beforeNormalization()
                        ->ifTrue(function ($v) { return is_string($v); })
                        ->then(function ($v) { return array($v); })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        $this->addCsrfSection($rootNode);
        $this->addFormSection($rootNode);
        $this->addEsiSection($rootNode);
        $this->addFragmentsSection($rootNode);
        $this->addProfilerSection($rootNode);
        $this->addRouterSection($rootNode);
        $this->addSessionSection($rootNode);
        $this->addRequestSection($rootNode);
        $this->addTemplatingSection($rootNode);
        $this->addTranslatorSection($rootNode);
        $this->addValidationSection($rootNode);
        $this->addAnnotationsSection($rootNode);
        $this->addSerializerSection($rootNode);

        return $treeBuilder;
    }

    private function addCsrfSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('csrf_protection')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('field_name')
                            ->defaultValue('_token')
                            ->info('Deprecated since 2.4, to be removed in 3.0. Use form.csrf_protection.field_name instead')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addFormSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('form')
                    ->info('form configuration')
                    ->canBeEnabled()
                    ->children()
                        ->arrayNode('csrf_protection')
                            ->treatFalseLike(array('enabled' => false))
                            ->treatTrueLike(array('enabled' => true))
                            ->treatNullLike(array('enabled' => true))
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('enabled')->defaultNull()->end() // defaults to framework.csrf_protection.enabled
                                ->scalarNode('field_name')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addEsiSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('esi')
                    ->info('esi configuration')
                    ->canBeEnabled()
                ->end()
            ->end()
        ;
    }

    private function addFragmentsSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('fragments')
                    ->info('fragments configuration')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('path')->defaultValue('/_fragment')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addProfilerSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('profiler')
                    ->info('profiler configuration')
                    ->canBeEnabled()
                    ->children()
                        ->booleanNode('collect')->defaultTrue()->end()
                        ->booleanNode('only_exceptions')->defaultFalse()->end()
                        ->booleanNode('only_master_requests')->defaultFalse()->end()
                        ->scalarNode('dsn')->defaultValue('file:%kernel.cache_dir%/profiler')->end()
                        ->scalarNode('username')->defaultValue('')->end()
                        ->scalarNode('password')->defaultValue('')->end()
                        ->scalarNode('lifetime')->defaultValue(86400)->end()
                        ->arrayNode('matcher')
                            ->canBeUnset()
                            ->performNoDeepMerging()
                            ->fixXmlConfig('ip')
                            ->children()
                                ->scalarNode('path')
                                    ->info('use the urldecoded format')
                                    ->example('^/path to resource/')
                                ->end()
                                ->scalarNode('service')->end()
                                ->arrayNode('ips')
                                    ->beforeNormalization()->ifString()->then(function ($v) { return array($v); })->end()
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addRouterSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('router')
                    ->info('router configuration')
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('resource')->isRequired()->end()
                        ->scalarNode('type')->end()
                        ->scalarNode('http_port')->defaultValue(80)->end()
                        ->scalarNode('https_port')->defaultValue(443)->end()
                        ->scalarNode('strict_requirements')
                            ->info(
                                "set to true to throw an exception when a parameter does not match the requirements\n".
                                "set to false to disable exceptions when a parameter does not match the requirements (and return null instead)\n".
                                "set to null to disable parameter checks against requirements\n".
                                "'true' is the preferred configuration in development mode, while 'false' or 'null' might be preferred in production"
                            )
                            ->defaultTrue()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addSessionSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('session')
                    ->info('session configuration')
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('storage_id')->defaultValue('session.storage.native')->end()
                        ->scalarNode('handler_id')->defaultValue('session.handler.native_file')->end()
                        ->scalarNode('name')->end()
                        ->scalarNode('cookie_lifetime')->end()
                        ->scalarNode('cookie_path')->end()
                        ->scalarNode('cookie_domain')->end()
                        ->booleanNode('cookie_secure')->end()
                        ->booleanNode('cookie_httponly')->end()
                        ->scalarNode('gc_divisor')->end()
                        ->scalarNode('gc_probability')->defaultValue(1)->end()
                        ->scalarNode('gc_maxlifetime')->end()
                        ->scalarNode('save_path')->defaultValue('%kernel.cache_dir%/sessions')->end()
                        ->integerNode('metadata_update_threshold')
                            ->defaultValue('0')
                            ->info('seconds to wait between 2 session metadata updates, it will also prevent the session handler to write if the session has not changed')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addRequestSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('request')
                    ->info('request configuration')
                    ->canBeUnset()
                    ->fixXmlConfig('format')
                    ->children()
                        ->arrayNode('formats')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->beforeNormalization()
                                    ->ifTrue(function ($v) { return is_array($v) && isset($v['mime_type']); })
                                    ->then(function ($v) { return $v['mime_type']; })
                                ->end()
                                ->beforeNormalization()
                                    ->ifTrue(function ($v) { return !is_array($v); })
                                    ->then(function ($v) { return array($v); })
                                ->end()
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addTemplatingSection(ArrayNodeDefinition $rootNode)
    {
        $organizeUrls = function ($urls) {
            $urls += array(
                'http' => array(),
                'ssl'  => array(),
            );

            foreach ($urls as $i => $url) {
                if (is_integer($i)) {
                    if (0 === strpos($url, 'https://') || 0 === strpos($url, '//')) {
                        $urls['http'][] = $urls['ssl'][] = $url;
                    } else {
                        $urls['http'][] = $url;
                    }
                    unset($urls[$i]);
                }
            }

            return $urls;
        };

        $rootNode
            ->children()
                ->arrayNode('templating')
                    ->info('templating configuration')
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('assets_version')->defaultValue(null)->end()
                        ->scalarNode('assets_version_format')->defaultValue('%%s?%%s')->end()
                        ->scalarNode('hinclude_default_template')->defaultNull()->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->fixXmlConfig('resource')
                            ->children()
                                ->arrayNode('resources')
                                    ->addDefaultChildrenIfNoneSet()
                                    ->prototype('scalar')->defaultValue('FrameworkBundle:Form')->end()
                                    ->validate()
                                        ->ifTrue(function ($v) {return !in_array('FrameworkBundle:Form', $v); })
                                        ->then(function ($v) {
                                            return array_merge(array('FrameworkBundle:Form'), $v);
                                        })
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->fixXmlConfig('assets_base_url')
                    ->children()
                        ->arrayNode('assets_base_urls')
                            ->performNoDeepMerging()
                            ->addDefaultsIfNotSet()
                            ->beforeNormalization()
                                ->ifTrue(function ($v) { return !is_array($v); })
                                ->then(function ($v) { return array($v); })
                            ->end()
                            ->beforeNormalization()
                                ->always()
                                ->then($organizeUrls)
                            ->end()
                            ->children()
                                ->arrayNode('http')
                                    ->prototype('scalar')->end()
                                ->end()
                                ->arrayNode('ssl')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->scalarNode('cache')->end()
                    ->end()
                    ->fixXmlConfig('engine')
                    ->children()
                        ->arrayNode('engines')
                            ->example(array('twig'))
                            ->isRequired()
                            ->requiresAtLeastOneElement()
                            ->beforeNormalization()
                                ->ifTrue(function ($v) { return !is_array($v); })
                                ->then(function ($v) { return array($v); })
                            ->end()
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                    ->fixXmlConfig('loader')
                    ->children()
                        ->arrayNode('loaders')
                            ->beforeNormalization()
                                ->ifTrue(function ($v) { return !is_array($v); })
                                ->then(function ($v) { return array($v); })
                             ->end()
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                    ->fixXmlConfig('package')
                    ->children()
                        ->arrayNode('packages')
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->fixXmlConfig('base_url')
                                ->children()
                                    ->scalarNode('version')->defaultNull()->end()
                                    ->scalarNode('version_format')->defaultValue('%%s?%%s')->end()
                                    ->arrayNode('base_urls')
                                        ->performNoDeepMerging()
                                        ->addDefaultsIfNotSet()
                                        ->beforeNormalization()
                                            ->ifTrue(function ($v) { return !is_array($v); })
                                            ->then(function ($v) { return array($v); })
                                        ->end()
                                        ->beforeNormalization()
                                            ->always()
                                            ->then($organizeUrls)
                                        ->end()
                                        ->children()
                                            ->arrayNode('http')
                                                ->prototype('scalar')->end()
                                            ->end()
                                            ->arrayNode('ssl')
                                                ->prototype('scalar')->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addTranslatorSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('translator')
                    ->info('translator configuration')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('fallback')->defaultValue('en')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addValidationSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('validation')
                    ->info('validation configuration')
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('cache')->end()
                        ->booleanNode('enable_annotations')->defaultFalse()->end()
                        ->arrayNode('static_method')
                            ->defaultValue(array('loadValidatorMetadata'))
                            ->prototype('scalar')->end()
                            ->treatFalseLike(array())
                            ->validate()
                                ->ifTrue(function ($v) { return !is_array($v); })
                                ->then(function ($v) { return (array) $v; })
                            ->end()
                        ->end()
                        ->scalarNode('translation_domain')->defaultValue('validators')->end()
                        ->booleanNode('strict_email')->defaultFalse()->end()
                        ->enumNode('api')
                            ->values(array('2.4', '2.5', '2.5-bc', 'auto'))
                            ->beforeNormalization()
                                // XML/YAML parse as numbers, not as strings
                                ->ifTrue(function ($v) { return is_scalar($v); })
                                ->then(function ($v) { return (string) $v; })
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->validate()
                ->ifTrue(function ($v) { return !isset($v['validation']['api']) || 'auto' === $v['validation']['api']; })
                ->then(function ($v) {
                    // This condition is duplicated in ValidatorBuilder. This
                    // duplication is necessary in order to know the desired
                    // API version already during container configuration
                    // (to adjust service classes etc.)
                    // See https://github.com/symfony/symfony/issues/11580
                    $v['validation']['api'] = version_compare(PHP_VERSION, '5.3.9', '<')
                        ? '2.4'
                        : '2.5-bc';

                    return $v;
                })
            ->end()
        ;
    }

    private function addAnnotationsSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('annotations')
                    ->info('annotation configuration')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('cache')->defaultValue('file')->end()
                        ->scalarNode('file_cache_dir')->defaultValue('%kernel.cache_dir%/annotations')->end()
                        ->booleanNode('debug')->defaultValue('%kernel.debug%')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addSerializerSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('serializer')
                    ->info('serializer configuration')
                    ->canBeEnabled()
                ->end()
            ->end()
        ;
    }
}
