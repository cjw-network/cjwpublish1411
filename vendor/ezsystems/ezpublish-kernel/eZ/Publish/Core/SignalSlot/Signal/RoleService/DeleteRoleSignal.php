<?php
/**
 * DeleteRoleSignal class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\SignalSlot\Signal\RoleService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * DeleteRoleSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\RoleService
 */
class DeleteRoleSignal extends Signal
{
    /**
     * RoleId
     *
     * @var mixed
     */
    public $roleId;
}
