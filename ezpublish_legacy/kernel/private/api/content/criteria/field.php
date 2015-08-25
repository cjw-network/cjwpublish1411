<?php
/**
 * File containing the ezpContentFieldCriteria class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package API
 */

/**
 * This class is used to instantiate and manipulate a field value content criteria.
 *
 * @package API
 */
class ezpContentFieldCriteria implements ezpContentCriteriaInterface
{
    public function __construct( $fieldIdentifier )
    {

    }

    /**
     * Adds a 'like' parameter to the criteria.
     *
     * @param string $string
     *
     * @return ezpContentFieldCriteria
     */
    public function like( $string )
    {

    }

    /**
     * Filter content on the value a string starts with
     *
     * @param string $string String the content has to start with
     *
     * @return ezpContentFieldCriteria
     */
    public function startsWith( $string )
    {

    }

    /**
     * Filter content on the value a string ends with
     *
     * @param string $string String the content has to end with
     *
     * @return ezpContentFieldCriteria
     */
    public function endsWith( $string )
    {

    }

    public function translate() {}

    public function __toString() {}
}
?>
