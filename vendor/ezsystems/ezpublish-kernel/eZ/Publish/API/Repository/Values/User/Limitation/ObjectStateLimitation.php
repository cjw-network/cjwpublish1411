<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\User\Limitation\ObjectStateLimitation class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\API\Repository\Values\User\Limitation;

use eZ\Publish\API\Repository\Values\User\Limitation;

/**
 * Class ObjectStateLimitation
 *
 * This Object state serves as API limitation for "StateGroup" from legacy,
 * StateGroup stored a combination of StateGroup identifier as well as State id(s) while this one
 * only cares about the state id's.
 *
 * @package eZ\Publish\API\Repository\Values\User\Limitation
 */
class ObjectStateLimitation extends Limitation
{
    /**
     * @see \eZ\Publish\API\Repository\Values\User\Limitation::getIdentifier()
     *
     * @return string
     */
    public function getIdentifier()
    {
        return Limitation::STATE;
    }
}
