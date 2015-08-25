<?php
/**
 * SetContentStateSignal class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\SignalSlot\Signal\ObjectStateService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * SetContentStateSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\ObjectStateService
 */
class SetContentStateSignal extends Signal
{
    /**
     * ContentId
     *
     * @var mixed
     */
    public $contentId;

    /**
     * ObjectStateGroupId
     *
     * @var mixed
     */
    public $objectStateGroupId;

    /**
     * ObjectStateId
     *
     * @var mixed
     */
    public $objectStateId;
}
