<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request\PropertyHandler\Override;
use Qafoo\RMF\Throwable;

/**
 * Exception thrown if no overriding property handler returned a value.
 *
 * @version $Revision$
 */
class NoValueFoundException extends \RuntimeException implements Throwable
{
}

