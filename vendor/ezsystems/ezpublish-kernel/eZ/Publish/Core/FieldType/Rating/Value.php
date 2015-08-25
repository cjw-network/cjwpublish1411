<?php
/**
 * File containing the Rating Value class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\FieldType\Rating;

use eZ\Publish\Core\FieldType\Value as BaseValue;

/**
 * Value for Rating field type
 */
class Value extends BaseValue
{
    /**
     * Is rating disabled
     *
     * @var boolean
     */
    public $isDisabled = false;

    /**
     * Construct a new Value object and initialize it with its $isDisabled state
     *
     * @param boolean $isDisabled
     */
    public function __construct( $isDisabled = false )
    {
        $this->isDisabled = $isDisabled;
    }

    /**
     * @see \eZ\Publish\Core\FieldType\Value
     */
    public function __toString()
    {
        return $this->isDisabled ? "1" : "0";
    }
}
