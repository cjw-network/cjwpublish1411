<?php
/**
 * File containing the ezpModuleViewDisabled exception.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/**
 * Exception occuring when a module/view is disabled.
 *
 * @package kernel
 */
class ezpModuleViewDisabled extends Exception
{
    /**
     * @var string
     */
    public $moduleName;

    /**
     * @var string
     */
    public $viewName;

    /**
     * Constructor
     *
     * @param string $moduleName
     */
    public function __construct( $moduleName, $viewName )
    {
        $this->moduleName = $moduleName;
        $this->viewName = $viewName;
    }
}
