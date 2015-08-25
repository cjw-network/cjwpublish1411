<?php
/**
 * File containing the ezcGraphNoSuchDataException class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception shown, when trying to access not existing data in datasets.
 *
 * @package Graph
 * @version //autogentag//
 */
class ezcGraphNoSuchDataException extends ezcGraphException
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
        parent::__construct( "No data with name '{$name}' found." );
    }
}

?>
