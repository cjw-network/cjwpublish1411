<?php
/**
 * File containing the Sessionable interface
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\REST\Client;

/**
 * Implementation of the {@link \eZ\Publish\API\Repository\SectionService}
 * interface.
 *
 * @see \eZ\Publish\API\Repository\SectionService
 */
interface Sessionable
{
    /**
     * Set session ID
     *
     * Only for testing
     *
     * @param mixed $id
     *
     * @private
     *
     * @return void
     */
    public function setSession( $id );
}

