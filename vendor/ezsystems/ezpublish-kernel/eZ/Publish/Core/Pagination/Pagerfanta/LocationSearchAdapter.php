<?php
/**
 * File containing the LocationSearchAdapter class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\Pagination\Pagerfanta;

/**
 * Pagerfanta adapter for eZ Publish content search.
 * Will return results as Location objects.
 */
class LocationSearchAdapter extends LocationSearchHitAdapter
{
    /**
     * Returns a slice of the results as Location objects.
     *
     * @param integer $offset The offset.
     * @param integer $length The length.
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Location[]
     */
    public function getSlice( $offset, $length )
    {
        $list = array();
        foreach ( parent::getSlice( $offset, $length ) as $hit )
        {
            $list[] = $hit->valueObject;
        }

        return $list;
    }
}
