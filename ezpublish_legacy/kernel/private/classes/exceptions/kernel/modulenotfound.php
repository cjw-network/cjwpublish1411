<?php
/**
 * File containing the ezpModuleNotFound exception.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/**
 * Exception occuring when a module is not found.
 *
 * @package kernel
 */
class ezpModuleNotFound extends Exception
{
    /**
     * @var string
     */
    public $moduleName;

    /**
     * Constructor
     *
     * @param string $moduleName
     */
    public function __construct( $moduleName )
    {
        $this->moduleName = $moduleName;
    }
}
