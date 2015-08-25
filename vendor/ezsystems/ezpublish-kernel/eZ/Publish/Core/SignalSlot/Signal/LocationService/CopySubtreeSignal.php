<?php
/**
 * CopySubtreeSignal class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\SignalSlot\Signal\LocationService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * CopySubtreeSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\LocationService
 */
class CopySubtreeSignal extends Signal
{
    /**
     * SubtreeId
     *
     * @var mixed
     */
    public $subtreeId;

    /**
     * TargetParentLocationId
     *
     * @var mixed
     */
    public $targetParentLocationId;

    /**
     * TargetNewSubtreeId
     *
     * @var mixed
     */
    public $targetNewSubtreeId;
}
