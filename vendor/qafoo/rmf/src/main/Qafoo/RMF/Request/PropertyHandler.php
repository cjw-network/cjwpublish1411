<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request;

/**
 * Property handler base class
 *
 * @version $Revision$
 */
abstract class PropertyHandler
{
    /**
     * Get value of property handler
     *
     * @return mixed
     */
    abstract public function getValue();
}

