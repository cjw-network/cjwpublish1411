<?php
/**
 * CopyContentSignal class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\SignalSlot\Signal\ContentService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * CopyContentSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\ContentService
 */
class CopyContentSignal extends Signal
{
    /**
     * Source Content ID
     *
     * @var mixed
     */
    public $srcContentId;

    /**
     * Source Version Number
     *
     * @var int|null
     */
    public $srcVersionNo;

    /**
     * Destination Content ID
     *
     * @var mixed
     */
    public $dstContentId;

    /**
     * Destination Version Number
     *
     * @var int
     */
    public $dstVersionNo;

    /**
     * Destination Parent Location ID
     *
     * @var mixed
     */
    public $dstParentLocationId;
}
