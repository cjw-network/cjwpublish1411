<?php
/**
 * File containing the CjwMultiSiteKernelMatcher class
 *
 * @copyright Copyright (C) 2007-2014 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @filesource
 *
 */
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Class CjwMultiSiteKernelMatcher
 *
 * Handles the logic to match a  SiteKernel
 *
 * TODO a global Logging for errors
 *
 */
class CjwMultiSiteKernelMatcher
{

    protected $activeSiteBundles = null;
    protected $configArray = null;
    protected $ezRootDir = null;
    protected $useCache = false;
    // dir of global cache for yaml parse output
    public  $globalCacheDir = false;
    // ttl of global cache in s 0 never expired
    protected $cacheTtl = 0;

    function __construct( $useCache = false )
    {
        $this->ezRootDir = __DIR__.'/../../../..';
        $this->useCache = $useCache;
        $this->globalCacheDir = $this->ezRootDir. '/ezpublish_legacy/var/cache_ezp5/cjwpublish';
        // cache ttl 3600 s
        // $this->cacheTtl = 3600;
    }

    /**
     *
     * Reloads the global cache which inlcudes data from cjwpublish.yml
     * can be called if a new site package is enabled on production
     *
     * @return configArray
     */
    public function reloadCache()
    {
        return $this->loadCjwPublishConfig( true );
    }

    /**
     *  cjwpublish.yml parsen und evtl später hier cachen
     *
     * @param bool $forceGenerateCache if true than the cache if is active will be new generated
     */
    public function loadCjwPublishConfig( $forceGenerateCache = false  )
    {

        if ( $this->configArray === null )
        {
            $cacheKey = 'cjwpublish.yml';
            $id = false;

            if ( $this->useCache === true )
            {
                // http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/caching.html
                $cache = new \Doctrine\Common\Cache\PhpFileCache( $this->globalCacheDir );
                // $cache = new \Doctrine\Common\Cache\ApcCache();

                // use cache only if not force to generate new
                if ( $forceGenerateCache === false )
                {
                    $id = $cache->fetch( $cacheKey );
                }
            }

            if ( $id )
            {
                $this->configArray = unserialize( $id );
                // echo "load cache";
            }
            else
            {

                $activeSiteBundleArray = $this->getActiveSiteBundles();

                //var_dump( $activeSiteBundleArray );
                $domainKernelMatchArray = array();
                $siteNameArray = array();

                // $siteBundle = Jac/SiteSvvStralundBundle
                foreach ( $activeSiteBundleArray as $siteBundleName )
                {
                    // Vor Großbuchstaben ein leerzeichen setzen
                    // Jac/SiteSvvStralsundBundle
                    $siteBundleClassName =  str_replace('/', '', $siteBundleName );

                    // Jac Site Svv Stralsund Bundle
                    $siteBundleClassNameWhitspace =  preg_replace('/([A-Z])/', ' $1', $siteBundleClassName );
                    $siteBundleClassNameComponents = explode( ' ', trim( $siteBundleClassNameWhitspace ) );

                    //var_dump( $siteBundleClassNameComponents );

                    // remove  ...Bundle from string
                    array_pop( $siteBundleClassNameComponents );

                    // JacSiteSvvStralsund
                    $siteClassBaseName =  implode( '',  $siteBundleClassNameComponents );

                    // remove  Jac from string
                    array_shift( $siteBundleClassNameComponents );
                    // remove Site from string
                    array_shift( $siteBundleClassNameComponents );

                    // svv-stralsund
                    $siteName = strtolower( implode( '-',  $siteBundleClassNameComponents ) );

                    $siteBundlePath = $this->ezRootDir  . '/src/' . $siteBundleName;

                    $siteYamlFile  = $siteBundlePath .'/app/config/cjwpublish.yml';

                    if ( file_exists( $siteYamlFile ) )
                    {
                        $siteArray = Yaml::parse( file_get_contents( $siteYamlFile ) );

                        if ( isset(  $siteArray['cjwpublish']['site']['domains'] ) )
                        {
                            foreach ( $siteArray['cjwpublish']['site']['domains'] as $domain )
                            {
                                $domainKernelMatchArray[ $domain ] = $siteName;
                            }
                        }
                        else
                        {
                            // errror app config file
                        }

                        $siteNameArray[ $siteName ] = array( 'class_base_name' => $siteClassBaseName,
                                                             'app_path'  => $siteBundlePath .'/app' );
                    }
                    else
                    {
                       // printf( "<br>Unable to find site cjwpublish.yml: %s", $siteYamlFile );
                    }
                }

                $this->configArray = array( 'active_site_bundles' => $activeSiteBundleArray,
                                            'domain_array' => $domainKernelMatchArray,
                                            'sitename_array' => $siteNameArray );

                if ( $this->useCache )
                {
                    // cache schreiben Verfallszeit auf 60s stellen
                    $cache->save( $cacheKey, serialize( $this->configArray ), $this->cacheTtl );
                    //echo "write cache";
                }
            }
        }

      //  var_dump($this->configArray);

        return $this->configArray;
    }


    /**
     * @see  configfile /ezroot/cjwpublish/config/cjwpublish.yml
     * @return bool or array with all Sitebundles which are activated
     */
    private function getActiveSiteBundles()
    {

        $sitesYamlFilePath = $this->ezRootDir .'/cjwpublish/config/cjwpublish.yml';

        try
        {
            $sitesArray = Yaml::parse( file_get_contents( $sitesYamlFilePath ) );
            $activeSiteBundles = $sitesArray['cjwpublish']['active_site_bundles'];
        }
        catch ( ParseException $e )
        {
            printf( "Unable to parse the YAML string: %s", $e->getMessage() );
            return false;
        }

        return $activeSiteBundles;

    }


    /**
     * try to find the kernel to current Hostname
     *
     * @param $hostName
     *
     * @return array
     */
    public function getKernelInfosByHostName( $hostName = false )
    {
        $cjwPublishConfig = $this->loadCjwPublishConfig();

        $domainKernelMatchArray = $cjwPublishConfig['domain_array'];
        //$siteNameArray = $cjwPublishConfig['sitename_array'];

        if ( $hostName === false )
        {
            // www.svv-stralsund.de.jac1311.fw.lokal
            $host = $_SERVER['HTTP_HOST'];
        }

        $kernelInfoArray = false;

        //
        // ################  Url auf Kernel Match
        //
        foreach ( $domainKernelMatchArray as $matchMapHost => $siteName )
        {

            // $hostName begins with $domain

            // JAC beginns with
            if ( strpos( $host, $matchMapHost ) === 0 )
            {
                $kernelInfoArray = $this->getKernelInfosBySiteName( $siteName );
                break;
            }
        }
        return $kernelInfoArray;
    }


    /**
     *
     * sucht zu einem sitename  'svv-stralsund' die alle KernelParameter die benötigt werden
     * um den Site Kernel zu initialisieren
     *
     * @param $siteName
     *
     * @return array
     */
    public function getKernelInfosBySiteName( $siteName )
    {

        $cjwPublishConfig = $this->loadCjwPublishConfig();

        //        $domainKernelMatchArray = $cjwPublishConfig['domain_array'];
        $siteNameArray = $cjwPublishConfig['sitename_array'];

        //        echo '<br>' . $host . ' - ' . $matchMapHost . ' - '. $siteProjectName;
        $siteArray = $siteNameArray[ $siteName ];

        //  .. /app
        $siteAppPath = $siteArray['app_path'];
        $siteClassBaseName = $siteArray['class_base_name'];

        // SiteSvvStralsundKernel
        $kernelClassName = $siteClassBaseName . 'Kernel';
        // SiteSvvStralsundCache
        $cacheClassName = $siteClassBaseName . 'Cache';

        $kernelInfoArray = array( 'site_name' => $siteName,
                                  'site_kernel_class_name' => $kernelClassName,
                                  'site_cache_class_name' => $cacheClassName,
                                  'site_app_path' => $siteAppPath );

        return $kernelInfoArray;
    }


}