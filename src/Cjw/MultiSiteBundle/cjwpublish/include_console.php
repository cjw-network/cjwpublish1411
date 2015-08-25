<?php
/**
 * File containing the cjwpublish/console logic
 *
 * @copyright Copyright (C) 2007-2014 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @filesource
 *
 */

use eZ\Bundle\EzPublishCoreBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Debug\Debug;

class IncludeConsole
{
    public $siteName;
    public $fullCommandString;

    /**
     * returns the full command string
     * eg. "app/console" or "console"
     *
     * @return mixed
     */
    public function getFullCommandString()
    {
        global $argv;
        return $this->fullCommandString = $argv[0];
    }

    /**
     * gets the full command name then returns only the sitename.
     * eg. gets "php app/console-myawesome-site" from command and returns "myawesome-site".
     */
    public function getSiteName()
    {
        $fullCommandString = $this->getFullCommandString();
        $commandNameOnly = substr($fullCommandString,0, strpos($fullCommandString, '-')+1);

        if( strlen($commandNameOnly) > 2)
        {
            //get the length of the string
            $this->siteName = substr( $fullCommandString, strlen($commandNameOnly));
        }
        else
        {
           $this->siteName = null;
        }

        return $this->siteName;
    }
}

$console = new IncludeConsole();
$siteName = $console->getSiteName();

//echo "This is the sitename: \n".$siteName."\n";

$createSiteSymlinks = false;

if ( isset( $argv[1] ) && $argv[1] == '--create-symlinks' )
{
    $createSiteSymlinks = true;
}
elseif ( is_null($siteName))
{
    echo "\n### No Sitename in console filename found - use the following syntax ###\n\n";
    echo "\tphp ./cjwpublish/console-sitename\n";
    echo "\nNotice: For every active SiteBundle you have to create a symlink:\n\n";
    echo "\tcd ezroot/cjwpublish\n";
    echo "\tln -s console console-sitename\n";


    echo "\nNotice: You can create all symlinks for all active SiteBundles with the following option:\n\n";
    echo "\tphp ./cjwpublish/console --create-symlinks\n\n\n";

    return;
}
else
{
//    echo "### Using SiteName: $siteName ###\n\n";
}

$ezrootDir = realpath( __DIR__ . '/../../../..' );

// if you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
umask( 0007 );

set_time_limit( 0 );

// Use autoload over boostrap here so we don't need to keep the generated files in git
require_once $ezrootDir . '/ezpublish/autoload.php';


$input = new ArgvInput();
$env = $input->getParameterOption( array( '--env', '-e' ), getenv( 'SYMFONY_ENV' ) ?: 'dev' );

$debug = getenv( 'SYMFONY_DEBUG' ) !== '0' && !$input->hasParameterOption( array( '--no-debug', '' ) ) && $env !== 'prod';
if ( $debug )
{
    Debug::enable();
}


require_once  $ezrootDir . '/src/Cjw/MultiSiteBundle/cjwpublish/CjwMultiSiteKernelMatcher.php';

$cjwMulitSiteKernelMatcher = new CjwMultiSiteKernelMatcher();
$cjwConfigArray = $cjwMulitSiteKernelMatcher->loadCjwPublishConfig();

//var_dump( $cjwConfigArray );

// create all console-sitename links for alle active Sites
if ( $createSiteSymlinks === true )
{
    echo "\n### Start Creating  Symlinks for cosole script for all active SiteBundles ###\n";

    foreach( $cjwConfigArray['sitename_array'] as $siteName2 => $siteNameArray )
    {
        // cjwpublish/console-my-project
        $link = "cjwpublish/console-$siteName2";

        if ( !file_exists( $link ) )
        {
            echo "\n[symlink] create:  $link => cjwpublish/console";
            symlink( 'console', $link );
        }
        else
        {
            echo "\n[symlink] exists:  $link => cjwpublish/console";
        }
    }

    echo "\n\n### Symlinks creation Done ###\n";
    return;
}

$kernelInfoArray = $cjwMulitSiteKernelMatcher->getKernelInfosBySiteName( $siteName );

//var_dump( $kernelInfoArray );

$siteAppPath = $kernelInfoArray['site_app_path'];
$siteKernelClassName = $kernelInfoArray['site_kernel_class_name'];


//echo "## lade kernel $siteKernelClassName ##\n";

require_once $siteAppPath .'/' . $siteKernelClassName . '.php';

$application = new Application( new $siteKernelClassName( $env, $debug ) );
$application->run( $input );
