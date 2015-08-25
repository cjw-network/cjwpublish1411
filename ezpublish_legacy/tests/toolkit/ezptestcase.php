<?php
/**
 * File containing the ezpTestCase class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package tests
 */

class ezpTestCase extends PHPUnit_Framework_TestCase
{
    protected $sharedFixture;

    protected $backupGlobals = false;
}

?>
