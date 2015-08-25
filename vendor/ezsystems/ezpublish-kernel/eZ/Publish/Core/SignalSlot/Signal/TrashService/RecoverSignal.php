<?php
/**
 * RecoverSignal class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\SignalSlot\Signal\TrashService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * RecoverSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\TrashService
 */
class RecoverSignal extends Signal
{
    /**
     * TrashItemId
     *
     * @var mixed
     */
    public $trashItemId;

    /**
     * NewParentLocationId
     *
     * @var mixed
     */
    public $newParentLocationId;

    /**
     * NewLocationId
     *
     * @var mixed
     */
    public $newLocationId;
}
