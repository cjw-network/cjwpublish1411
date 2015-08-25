<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\View;
use Qafoo\RMF\Throwable;

/**
 * Exception thrown when no view could be found during dispatching
 *
 * @version $Revision$
 */
class NowViewFoundException extends \RuntimeException implements Throwable
{
}

