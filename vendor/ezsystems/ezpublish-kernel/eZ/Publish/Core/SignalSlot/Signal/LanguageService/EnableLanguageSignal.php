<?php
/**
 * EnableLanguageSignal class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\SignalSlot\Signal\LanguageService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * EnableLanguageSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\LanguageService
 */
class EnableLanguageSignal extends Signal
{
    /**
     * LanguageId
     *
     * @var mixed
     */
    public $languageId;
}
