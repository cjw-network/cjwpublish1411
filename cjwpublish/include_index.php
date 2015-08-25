<?php
/**
 * File containing the include_index.php logic
 *
 * @copyright Copyright (C) 2007-2014 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @filesource
 *
 */

// server umgebungsvariablen setzen
// geht nur wenn nicht im webserver bereits gesetzt
//putenv( "ENVIRONMENT=dev" );
//putenv( "ENVIRONMENT=prod" );
//putenv( "USE_APC_CLASSLOADER=1" );
//putenv( "USE_DEBUGGING=0" );
//putenv( "USE_HTTP_CACHE=1" );

// nginx < 1.7.3 kann nicht mit etags und gzip umgehen und entfernt dadurch den etag
// workaround gzip in nginx ausschalten und umgebungsvariable CJW_PHP_ZLIP_OUTPUT_COMPRESSION=1 setzen
// mit  fastcgi_param CJW_PHP_ZLIP_OUTPUT_COMPRESSION 1;
// dann funktionieren etag + outputcompression
//
// putenv( "CJW_PHP_ZLIP_OUTPUT_COMPRESSION=1" );

// wenn gzip bei nginx ausgaschaltet ist damit etags funzen
//
//  !! Achtung: !! gibt probleme beim Ausliefern von Seiten teilweise sehr lange darum gzip von nginx
// nutzen und auf neue nginx version warten die etags zu weak etags umwandelt
//
//if ( (int) getenv( "CJW_PHP_ZLIP_OUTPUT_COMPRESSION" ) == 1 && !headers_sent() )
//{
//    // enable gzip outputcompression
//    // level 1 because this gives the most value  nearly 4/5 of html size is reduced
//    // but request is smallest => getting bigger as higher the compression level is
//    ini_set( 'zlib.output_compression', 'On' );
//    ini_set( 'zlib.output_compression_level', 2 );
//}


// load index php from CjwMultiSiteBundle
require_once "../src/Cjw/MultiSiteBundle/cjwpublish/include_index.php";
