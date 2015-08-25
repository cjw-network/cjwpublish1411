<?php
/**
 * File containing the Block id matcher class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\MVC\Symfony\Matcher\Block\Id;

use eZ\Publish\Core\MVC\Symfony\Matcher\Block\MultipleValued;
use eZ\Publish\Core\FieldType\Page\Parts\Block as PageBlock;

class Zone extends MultipleValued
{
    /**
     * Checks if a Block object matches.
     *
     * @param \eZ\Publish\Core\FieldType\Page\Parts\Block $block
     *
     * @return boolean
     */
    public function matchBlock( PageBlock $block )
    {
        return isset( $this->values[$block->zoneId] );
    }
}
