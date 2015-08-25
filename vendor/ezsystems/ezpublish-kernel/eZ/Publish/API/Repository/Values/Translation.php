<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\Message class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package eZ\Publish\API\Repository\Values
 */

namespace eZ\Publish\API\Repository\Values;

/**
 * Base class fro translation messages.
 *
 * Use its extensions: Translation\Singular, Translation\Plural.
 *
 * @package eZ\Publish\API\Repository\Values
 */
abstract class Translation extends ValueObject
{
}

