<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$Module = array( "name" => "eZError" );

$ViewList = array();
$ViewList["view"] = array(
    "script" => "view.php",
    "params" => array( 'Type', 'Number', 'ExtraParameters' ) );

?>
