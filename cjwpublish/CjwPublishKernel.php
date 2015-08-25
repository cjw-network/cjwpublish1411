<?php
/**
 * File containing the CjwPublishKernel class
 *
 * @copyright Copyright (C) 2007-2014 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @filesource
 *
 */

require_once __DIR__ . '/../src/Cjw/MultiSiteBundle/cjwpublish/CjwMultiSiteKernel.php';


use Egulias\ListenersDebugCommandBundle\EguliasListenersDebugCommandBundle;
use eZ\Bundle\EzPublishCoreBundle\EzPublishCoreBundle;
use eZ\Bundle\EzPublishDebugBundle\EzPublishDebugBundle;
use eZ\Bundle\EzPublishIOBundle\EzPublishIOBundle;
use eZ\Bundle\EzPublishLegacyBundle\EzPublishLegacyBundle;
use eZ\Bundle\EzPublishRestBundle\EzPublishRestBundle;
use EzSystems\CommentsBundle\EzSystemsCommentsBundle;
use EzSystems\DemoBundle\EzSystemsDemoBundle;
use EzSystems\EzSystemsBehatBundle;
use eZ\Bundle\EzPublishCoreBundle\Kernel;
use EzSystems\NgsymfonytoolsBundle\EzSystemsNgsymfonytoolsBundle;
use FOS\HttpCacheBundle\FOSHttpCacheBundle;
use Liip\ImagineBundle\LiipImagineBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\AsseticBundle\AsseticBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle;
use Sensio\Bundle\DistributionBundle\SensioDistributionBundle;
use Tedivm\StashBundle\TedivmStashBundle;
use WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle;
use WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle;
use Nelmio\CorsBundle\NelmioCorsBundle;
use Hautelook\TemplatedUriBundle\HautelookTemplatedUriBundle;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Knp\Bundle\MenuBundle\KnpMenuBundle;
use Oneup\FlysystemBundle\OneupFlysystemBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;

class CjwPublishKernel extends CjwMultiSiteKernel
{

    /**
     * Constructor.
     *
     * @param string  $siteName The name of the project
     * @param string  $environment The environment
     * @param Boolean $debug       Whether to enable debugging or not
     *
     * @api
     */
    public function __construct(  $environment, $debug )
    {
        // separate var and logs and cache dirs so we can moount this dir into ram or
        // somewhere else

        // /ezpublish_legacy/var_cache/{projectname}/cache_ezp5/{env}
        $this->siteSeparateVarCacheDir = true;
        // /ezpublish_legacy/var_log/{projectname}/cache_ezp5/{env}
        $this->siteSeparateVarLogDir = true;

        parent::__construct( $environment, $debug );
    }

    /**
     * Override the default loaded Bundles from ez 2014.11
     * @see eZPublishKernel::registerBundles
     *
     * Returns an array of bundles to registers.
     *
     * @return array An array of bundle instances.
     *
     * @api
     */
    public function registerBundles()
    {
        $bundles = array(
            new FrameworkBundle(),
            new SecurityBundle(),
            new TwigBundle(),
            new MonologBundle(),
            new SwiftmailerBundle(),
            new AsseticBundle(),
            new DoctrineBundle(),
            new SensioFrameworkExtraBundle(),
            new TedivmStashBundle(),
            new HautelookTemplatedUriBundle(),
            new LiipImagineBundle(),
            new FOSHttpCacheBundle(),
            new EzPublishCoreBundle(),
            new EzPublishLegacyBundle( $this ),
            new EzPublishIOBundle(),
//            new EzSystemsDemoBundle(),
            new EzPublishRestBundle(),
//            new EzSystemsCommentsBundle(),
//            new EzSystemsNgsymfonytoolsBundle(),
            // is used in Netgen/TagsBundle so we have to activate it
            new WhiteOctoberPagerfantaBundle(),
//            new WhiteOctoberBreadcrumbsBundle(),
//            new NelmioCorsBundle(),
//            new KnpMenuBundle(),
            new Oneup\FlysystemBundle\OneupFlysystemBundle()
        );

        switch ( $this->getEnvironment() )
        {
            case "test":
            case "behat":
                $bundles[] = new EzSystemsBehatBundle();
            // No break, test also needs dev bundles
            case "dev":
                $bundles[] = new EzPublishDebugBundle();
                $bundles[] = new WebProfilerBundle();
                $bundles[] = new SensioDistributionBundle();
                $bundles[] = new SensioGeneratorBundle();
                $bundles[] = new EguliasListenersDebugCommandBundle();
        }

        // get global bundles
        $globalBundles = $this->registerGlobalBundles();
        $bundles = array_merge( $bundles, $globalBundles );

        return $bundles;
    }


    /**
     * This method can be used to load additional bundles for all Kernels
     *
     * @return array|\Symfony\Component\HttpKernel\Bundle\Bundle[]
     */
    public function registerGlobalBundles()
    {
        $bundles = array();
        $bundles[] = new Cjw\MultiSiteBundle\CjwMultiSiteBundle();
        return $bundles;
    }

}
