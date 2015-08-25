<?php
/**
 * AssignSectionSignal class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\SignalSlot\Signal\SectionService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * AssignSectionSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\SectionService
 */
class AssignSectionSignal extends Signal
{
    /**
     * ContentId
     *
     * @var mixed
     */
    public $contentId;

    /**
     * SectionId
     *
     * @var mixed
     */
    public $sectionId;
}
