<?php
/**
 * File containing the eZ\Publish\API\Repository\Exceptions\NotFoundException class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\API\Repository\Exceptions;

use Exception;

/**
 * This Exception is thrown if an object referenced by an id or identifier
 * could not be found in the repository.
 * @package eZ\Publish\API\Repository\Exceptions
 */
abstract class NotFoundException extends Exception
{
}
