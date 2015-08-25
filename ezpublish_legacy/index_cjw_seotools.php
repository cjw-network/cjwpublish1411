<?php
/**
 * File index_cjw_seotools.php
 *
 * mini index script which must be located in ezroot
 * and all requests for robots.txt and sitemap.xml have to be
 * rewrite to this script
 *
 * @copyright Copyright (C) 2007-2011 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package cjw_seotools
 * @filesource
 */

//var_dump( $_SERVER );

// wrapper script for sitemap + robots.txt

include_once ( 'extension/cjw_seotools/include_cjw_seotools.php' );

?>