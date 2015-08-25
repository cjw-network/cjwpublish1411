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


// load index php from CjwMultiSiteBundle
require_once "../src/Cjw/MultiSiteBundle/cjwpublish/include_index.php";
