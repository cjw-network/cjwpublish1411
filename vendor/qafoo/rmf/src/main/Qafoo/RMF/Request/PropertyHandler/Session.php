<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request\PropertyHandler;
use Qafoo\RMF\Request\PropertyHandler;

/**
 * Property handler for PHP sessions
 *
 * @version $Revision$
 */
class Session extends PropertyHandler
{
    /**
     * Construct
     *
     * @return void
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Get value of property handler
     *
     * @return mixed
     */
    public function getValue()
    {
        return new Session\Wrapper();
    }
}

