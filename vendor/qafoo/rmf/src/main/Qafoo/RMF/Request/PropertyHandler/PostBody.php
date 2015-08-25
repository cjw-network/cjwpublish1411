<?php
/**
 * This file is part of the Qafoo RMF Component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request\PropertyHandler;

use \Qafoo\RMF\Request\PropertyHandler;

/**
 * Property handler that returns the parsed POST data
 *
 * @version $Revision$
 */
class PostBody extends PropertyHandler
{
    /**
     * Returns the raw request body.
     *
     * @return string
     */
    public function getValue()
    {
        return $_POST;
    }
}
