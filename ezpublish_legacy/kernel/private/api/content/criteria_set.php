<?php
/**
 * File containing the ezpContentCriteriaSet class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package API
 */

/**
 * This class handles a list of content query criteria
 * @package API
 */
class ezpContentCriteriaSet implements ArrayAccess, Countable, Iterator
{
    /**
     * Array offset setter
     * Called when a criteria is added. Expects an empty array index syntax.
     *
     * @param mixed $offset
     * @param eZContentCriteria $value
     */
    public function offsetSet( $offset, $value )
    {
        $this->criteria[] = $value;
    }

    /**
     * Array offset getter
     *
     * @param mixed $offset
     */
    public function offsetGet( $offset ){}

    public function offsetExists( $offset ){}

    public function offsetUnset( $offset ){}

    /**
     * Returns the number of registered criteria
     * @note Implements the count() method of the Countable interface
     * @return int
     */
    public function count()
    {
        return count( $this->criteria );
    }

    //// Iterator interface

    public function key()
    {
        return  $this->pointer;
    }

    public function current ()
    {
        return $this->criteria[$this->pointer];
    }

    public function next()
    {
        ++$this->pointer;
    }

    public function rewind()
    {
        $this->pointer = 0;
    }

    public function valid()
    {
        return isset( $this->criteria[$this->pointer] );
    }

    private $criteria = array();

    /**
     * Iterator interface pointer
     * @var int
     */
    private $pointer = 0;
}
?>
