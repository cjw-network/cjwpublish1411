<?php
/**
 * File containing the unit tests bootstrap file.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

$file = __DIR__ . '/../vendor/autoload.php';
if ( !file_exists( $file ) )
{
    throw new RuntimeException( 'Install dependencies to run test suite.' );
}

require_once $file;
