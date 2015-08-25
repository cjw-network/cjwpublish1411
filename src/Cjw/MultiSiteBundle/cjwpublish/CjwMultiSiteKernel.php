<?php
/**
 * File containing the CjwMultiSiteKernel class
 *
 * @copyright Copyright (C) 2007-2014 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @filesource
 *
 */

use Symfony\Component\Config\Loader\LoaderInterface;

require_once __DIR__ . '/../../../../ezpublish/EzPublishKernel.php';

class CjwMultiSiteKernel extends EzPublishKernel
{
    // test-project
    protected $siteProjectName = null;
    // SiteTestProjectKernel
    protected $siteKernelClassName = null;

    // SiteTestProjectBundle
    protected $siteKernelBundleName = null;

    protected $siteEzPublishLegacyRootDir = null;
    protected $siteCacheDir = null;
    protected $siteLogDir = null;

    protected $siteSeparateVarCacheDir = false;
    protected $siteSeparateVarLogDir = false;

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
        // temporarily fix libxml2-2.9.2 bug used in fedora 22 and other distros
        // https://jira.ez.no/browse/EZP-23846
        // https://www.drupal.org/node/2386903
        libxml_use_internal_errors(true);

        $this->siteProjectName = $this->getSiteName();
        $this->siteKernelClassName = $this->getSiteKernelClassName();
        $this->siteKernelBundleName = $this->getSiteKernelBundleName();

        // .../web
        $webDir = getcwd();
        /*
        // webmode
        if ( isset( $_SERVER['HTTP_HOST'] ) )
        {
            $this->siteEzPublishLegacyRootDir = "{$webDir}/../ezpublish_legacy";
        }
        else
        {
            // cli
            // php ./cjwpublish/console ....
            $this->siteEzPublishLegacyRootDir = "{$webDir}/ezpublish_legacy";
        }
        */
        $webDir = preg_replace('/\/web$/', '', $webDir);
        $this->siteEzPublishLegacyRootDir = "{$webDir}/ezpublish_legacy";
        //$this->siteSeparateVarCacheDir = false;
        //$this->siteSeparateVarLogDir = false;

        parent::__construct( $environment, $debug );
    }

    /**
     *  generate the Projectname from Kernel Class Name
     *
     * e.g.  CjwSiteMyProjectKernel   => my-project
     *       CjwSiteCjwNetworkKernel  => cjw-network
     *       CjwSiteCjwnetworkKernel  => cjwnetwork
     *
     * @return string name of the site e.g. site_default
     */
    public function getSiteName()
    {
        $kernelClassName = $this->getSiteKernelClassName();

        // Vor Großbuchstaben ein leerzeichen setzen
        $siteProjectName =  preg_replace('/([A-Z])/', ' $1', $kernelClassName );

        $kernelNameComponents = explode( ' ', trim( $siteProjectName ) );
        array_shift( $kernelNameComponents );
        array_shift( $kernelNameComponents );
        array_pop( $kernelNameComponents );

        $siteProjectName = strtolower( implode( '-',  $kernelNameComponents ) );
        return $siteProjectName;
    }

    /**
     * @return string SiteTestProjectKernel
     */
    public function getSiteKernelClassName()
    {
        // return the ClassName Site...Kernel
        return  get_called_class();
    }

    /**
     * This method can be used to load additional bundles.
     * It should call parent::registerBundles in order to load all Bundles required to run EzPublish.
     *
     * @return array|\Symfony\Component\HttpKernel\Bundle\Bundle[]
     */
    public function registerBundles()
    {
        $bundles = parent::registerBundles();

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

    /**
     * Loads the container configuration
     *
     * @param LoaderInterface $loader A LoaderInterface instance
     *
     * @api
     */
    public function registerContainerConfiguration( LoaderInterface $loader )
    {
        $environment = $this->getEnvironment();
        $appDir = $this->rootDir;

        $loader->load( $appDir . '/config/config_' . $environment . '.yml' );
        $configFile = $appDir . '/config/ezpublish_' . $environment . '.yml';

        if ( !is_readable( $configFile ) )
        {
            throw new RuntimeException( "Configuration file '$configFile' is not readable." );
        }

        $loader->load( $configFile );

        $configFileGlobal = $appDir . '/../../../../cjwpublish/config/config_' . $environment . '.yml';

        if ( !is_readable( $configFileGlobal ) )
        {
            throw new RuntimeException( "Configuration file '$configFileGlobal' is not readable." );
        }

        $loader->load( $configFileGlobal );
    }

    /**
     *
     *
     *  Kernel Name¶
     * type: string default: app (i.e. the directory name holding the kernel class)
     *
     * To change this setting, override the getName() method. Alternatively, move your kernel into a different directory. For example, if you moved the kernel into a foo directory (instead of app), the kernel name will be foo.
     *
     * The name of the kernel isn't usually directly important - it's used in the generation of cache files. If you have an application with multiple kernels, the easiest way to make each have a unique name is to duplicate the app directory and rename it to something else (e.g. foo).
     *
     * @return mixed|string|void
     */
    public function getName()
    {
        if ( null === $this->name )
        {
            $this->name = preg_replace('/[^a-zA-Z0-9_]+/', '', $this->siteKernelClassName );
        }
        return $this->name;
    }

    public function getCacheDir()
    {
        //return $this->rootDir . '/my_cache/' . $this->environment;
        if ( null === $this->siteCacheDir )
        {
            $varDir = $varCacheDir  = 'var';
            if ( $this->siteSeparateVarCacheDir )
            {
                $varCacheDir = 'var_cache';
            }
            // cache + logs unter projectnamen
            $this->siteCacheDir = "{$this->siteEzPublishLegacyRootDir}/{$varCacheDir}/{$this->siteProjectName}/cache_ezp5/{$this->environment}";
        }
        return $this->siteCacheDir;
    }

    public function getLogDir()
    {
        //return $this->rootDir . '/my_logs';

        if ( null === $this->siteLogDir )
        {
            $varDir = $varLogDir  = 'var';
            if ( $this->siteSeparateVarLogDir )
            {
                $varLogDir = 'var_log';
            }
            $this->siteLogDir = "{$this->siteEzPublishLegacyRootDir}/{$varLogDir}/{$this->siteProjectName}/log_ezp5";
        }

        return $this->siteLogDir;
    }

    /**
     * Name of The Bundle the MultisiteKernel ist placed
     * @return string SiteTestProjectBundle
     */
    public function getSiteKernelBundleName()
    {
        $kernelClassName = $this->getSiteKernelClassName();
        $bundleName = str_replace( 'Kernel', 'Bundle', $kernelClassName );

        return  $bundleName;
    }

    protected function getKernelParameters()
    {
        $result = array_merge(
            parent::getKernelParameters(),
            array(
                'cjw_kernel.site_name' => $this->siteProjectName,
                'cjw_kernel.bundle_name' => $this->siteKernelBundleName
            )
        );
        // var_dump( $result );
        return $result;
    }

  /*  public function getRootDir()
    {
        if ( null === $this->rootDir )
        {
            $r = new \ReflectionObject( $this );
            $this->rootDir = str_replace('\\', '/', dirname( $r->getFileName() ));

     //       $this->rootDir = $this->siteNameMatchArray[$this->siteName]['root_dir'];

        }

        return $this->rootDir;
    }*/

   /* public function serialize()
    {
  //      return serialize( array( $this->environment, $this->debug, $this->siteName ) );
    }*/

/*    public function unserialize($data)
    {
//        list($environment, $debug, $siteName ) = unserialize($data);
//        $this->__construct($environment, $debug , $siteName );
    }
*/
}
