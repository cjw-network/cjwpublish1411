<?php
/**
 * File containing the cjwpublish index.php logic
 *
 * @copyright Copyright (C) 2007-2014 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @filesource
 *
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\Debug\Debug;



$ezrootDir =  realpath(__DIR__ . '/../../../..' );


// Environment is taken from "ENVIRONMENT" variable, if not set, defaults to "prod"

$environment = getenv( "ENVIRONMENT" );

if ( $environment === false )
{
    $environment = "prod";
}


// The site is selected by the SITE environment variable. Default: ezpublish
$siteName = getenv( 'SITE' );

// use
// putenv( "ENVIRONMENT=dev" );
// in index.php or webserver to set env

$loader = require_once $ezrootDir . '/ezpublish/bootstrap.php.cache';

// Depending on the USE_APC_CLASSLOADER environment variable, use APC for autoloading to improve performance.
// If not set it is not used.
if ( getenv( "USE_APC_CLASSLOADER" ) )
{

    $prefix = getenv( "APC_CLASSLOADER_PREFIX" );

    $loader = new ApcClassLoader( $prefix ?: "ezpublish", $loader );
    $loader->register( true );
}


// CjwMultiSiteLoader

/*$kernelInfoArray = array(
                            'site_name' => 'svv-stralsund',
                            'site_kernel_class_name' =>  'JacSiteSvvStralsundKernel',
                            'site_cache_class_name' =>  'JacSiteSvvStralsundCache',
                            'site_app_path' =>  '/mnt/htdocs/jac1311/src/Cjw/MultiSiteBundle/cjwpublish/../../../../src/Jac/SiteSvvStralsundBundle/app'
                        );
*/


require_once  $ezrootDir . '/src/Cjw/MultiSiteBundle/cjwpublish/CjwMultiSiteKernelMatcher.php';

$useCache = true;
if ( $environment == 'dev' )
{
    $useCache = false;
}
$cjwMulitSiteKernelMatcher = new CjwMultiSiteKernelMatcher( $useCache );

// force reloading cache e.g. if a new site is enabled
//$cjwMulitSiteKernelMatcher->reloadCache();

// matching by Hostname begins with sitedomain
if ( $siteName === false )
{
    $kernelInfoArray = $cjwMulitSiteKernelMatcher->getKernelInfosByHostName();
}
// matching by siteName getenv
else
{
    $kernelInfoArray = $cjwMulitSiteKernelMatcher->getKernelInfosBySiteName( $siteName );
}

//echo "<h1>kernel info array</h1>";
//var_dump( $kernelInfoArray );

$siteAppPath = $kernelInfoArray['site_app_path'];
$kernelClassName = $kernelInfoArray['site_kernel_class_name'];
$cacheClassName = $kernelInfoArray['site_cache_class_name'];

if ( !file_exists( $siteAppPath ) ) {
    header("HTTP/1.0 404 Not Found");

    echo 'The site "' . $siteName . '" does not exist.';
    exit;
}


require_once $siteAppPath . DIRECTORY_SEPARATOR . $kernelClassName . '.php';
require_once $siteAppPath . DIRECTORY_SEPARATOR . $cacheClassName . '.php';

// Depending on the USE_DEBUGGING environment variable, tells whether Symfony should be loaded with debugging.
// If not set it is activated if in "dev" environment.
if ( ( $useDebugging = getenv( "USE_DEBUGGING" ) ) === false )
{
    $useDebugging = $environment === "dev";
}
if ( $useDebugging )
{
    Debug::enable();
}

$kernel = new $kernelClassName( $environment, $useDebugging );
$kernel->loadClassCache();

// Depending on the USE_HTTP_CACHE environment variable, tells whether the internal HTTP Cache mechanism is to be used.
// If not set it is activated if not in "dev" environment.
if ( ( $useHttpCache = getenv( "USE_HTTP_CACHE" ) ) === false )
{
    $useHttpCache = $environment !== "dev";
}
// Load HTTP Cache ...
if ( $useHttpCache )
{
     $kernel = new $cacheClassName( $kernel );
}

$request = Request::createFromGlobals();

// If you are behind one or more trusted reverse proxies, you might want to set them in TRUSTED_PROXIES environment
// variable in order to get correct client IP
if ( ( $trustedProxies = getenv( "TRUSTED_PROXIES" ) ) !== false )
{
    Request::setTrustedProxies( explode( ",", $trustedProxies ) );
}

$response = $kernel->handle( $request );

//
// Cache-Control	no-cache, must-revalidate
//
// client und proxies anhalten die Seite immer zu laden
// nur im http_cache lokal wird cache genriert mit ttls wie in ez gesetzt
// altes ez verhalten
// der server kontrolliert vollkommen das ausliefern der Seite
//$response->headers->set( 'Cache-Control', 'no-cache, must-revalidate' );

$response->send();
$kernel->terminate( $request, $response );



