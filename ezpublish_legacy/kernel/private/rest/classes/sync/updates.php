<?php
/**
 * File containing the ezpUpdatedContent class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/**
 * This class provides API through which one can query for updated content items.
 *
 * The class acts as an intermediate layer between existing API and new API,
 * which can be specially purposed for determining new content.
 *
 * There might be more filter functionality setup between the retrieval calls
 * so that new buisness logic can be created to create custom update streams,
 * independent of actual content structure.
 */

abstract class ezpUpdatedContent
{
    /**
     * Return the defined streams of content updates.
     *
     * A site usually consists of sections of different types of topics, e.g.
     * 'business', 'technology' and so on. These are meant to define logical
     * streams potentially consisting several sources underneath
     *
     * Note: The type of the categories are not yet decided.
     *
     * @return mixed
     */
    public function getCategories() {}

    /**
     * Returns new items, in specied $category, since last $logicalPointOfTime
     *
     * An optimized method to retrieve updated content from the repository.
     *
     * Note: the final format of this method has not yet been finalized.
     *
     * @param string $category
     * @param string $logicalPointOfTime
     * @return mixed
     */
    public function getUpdates( $category, $logicalPointOfTime ) {}
}

?>
