<?php
/**
 * CreateLocationSignal class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\SignalSlot\Signal\LocationService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * CreateLocationSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\LocationService
 */
class CreateLocationSignal extends Signal
{
    /**
     * ContentId
     *
     * @var mixed
     */
    public $contentId;

    /**
     * Location ID
     *
     * @var mixed
     */
    public $locationId;
}
