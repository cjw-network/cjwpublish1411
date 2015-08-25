<?php

namespace Netgen\TagsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * This is the class that loads and manages the bundle configuration
 */
class NetgenTagsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load( array $configs, ContainerBuilder $container )
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration( $configuration, $configs );

        $loader = new YamlFileLoader( $container, new FileLocator( __DIR__ . "/../Resources/config" ) );

        $loader->load( "services.yml" );
        $loader->load( "fieldtypes.yml" );
        $loader->load( "persistence.yml" );
        $loader->load( "storage_engines/legacy.yml" );
        $loader->load( "papi.yml" );
        $loader->load( "default_settings.yml" );
        $loader->load( "roles.yml" );
    }
}
