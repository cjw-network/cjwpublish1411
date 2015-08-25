<?php
/**
 * File containing the ezcGraphNoSuchElementException class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when trying to access a non existing chart element.
 *
 * @package Graph
 * @version //autogentag//
 */
class ezcGraphNoSuchElementException extends ezcGraphException
{
    /**
     * Constructor
     * 
     * @param string $name
     * @return void
     * @ignore
     */
    public function __construct( $name )
    {
        parent::__construct( "No chart element with name '{$name}' found." );
    }
}

?>
