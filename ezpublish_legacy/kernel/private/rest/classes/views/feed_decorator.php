<?php
/**
 * File containing the ezpRestFeedDecorator class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/**
 * This class decorates the feed provided in the REST interface
 * for content sync mechanisms.
 *
 * The interface is  based on the in-progress ezcMvcFeedDecorator interface.
 *
 * The decorator objects should be able describe the various syncing streams,
 * the decorator needs to be able to extract relevant information for defined
 * streams via an interface suited for this purpose.
 *
 * @package rest
 */
class ezpRestFeedDecorator
{
    public function decorateFeed( ezcFeed $feed )
    {
    }

    /**
     * Returns the name of the variable in the result object to decorate
     *
     * @return string
     */
    public function getItemVariable()
    {
    }

    /**
     * Adds feed metadata pertaining to the item's data specified in $data
     *
     * @todo Add list of required metadata to add
     *
     * @param string $ezcFeedEntryElement
     * @param string $data
     * @return void
     */
    public function decorateFeedItem( ezcFeedEntryElement $item, $data )
    {
    }
}
?>
