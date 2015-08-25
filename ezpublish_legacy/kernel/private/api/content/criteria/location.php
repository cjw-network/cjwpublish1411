<?php
/**
 * File containing the ezpContentLocationCriteria class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package API
 */

/**
 * This class allows for configuration of a location based criteria
 * @package API
 */
class ezpContentLocationCriteria implements ezpContentCriteriaInterface
{
    /**
     * Sets a subtree criteria.
     * Content will only be accepted if it is part of the given subtree
     *
     * @param ezpLocation $subtree
     * @return ezpContentLocationCriteria
     */
    public function subtree( ezpContentLocation $subtree )
    {
        $this->subtree = $subtree;
        return $this;
    }

    /**
     * Temporary function that translates the criteria to something eZContentObjectTreeNode understands
     * @return array
     */
    public function translate()
    {
        return array( 'type' => 'location', 'value' => $this->subtree->node_id );
    }

    public function __toString()
    {
        return "part of subtree " . $this->subtree->node_id;
    }

    /**
     * @var ezpContentLocation
     */
    private $subtree;
}
?>
