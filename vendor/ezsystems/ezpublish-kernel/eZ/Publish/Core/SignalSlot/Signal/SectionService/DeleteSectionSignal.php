<?php
/**
 * DeleteSectionSignal class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\SignalSlot\Signal\SectionService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * DeleteSectionSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\SectionService
 */
class DeleteSectionSignal extends Signal
{
    /**
     * SectionId
     *
     * @var mixed
     */
    public $sectionId;
}
