<?php
/**
 * MoveSubtreeSignal class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\SignalSlot\Signal\LocationService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * MoveSubtreeSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\LocationService
 */
class MoveSubtreeSignal extends Signal
{
    /**
     * LocationId
     *
     * @var mixed
     */
    public $locationId;

    /**
     * NewParentLocationId
     *
     * @var mixed
     */
    public $newParentLocationId;
}
