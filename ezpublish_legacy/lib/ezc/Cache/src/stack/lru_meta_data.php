<?php
/**
 * File containing the ezcCacheStackLruMetaData class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Meta data for the LRU replacement strategy.
 *
 * This meta data class is to be used with the {@link ezcCacheStackLruMetaData}.
 *
 * @package Cache
 * @version //autogen//
 *
 * @access private
 */
class ezcCacheStackLruMetaData extends ezcCacheStackBaseMetaData
{
    /**
     * Adds the given $itemId to the replacement data.
     *
     * Assigns the current {@link time()} to the entry for $itemId.
     * 
     * @param string $itemId 
     */
    public function addItemToReplacementData( $itemId )
    {
        $this->replacementData[$itemId] = time();
    }
}

?>
