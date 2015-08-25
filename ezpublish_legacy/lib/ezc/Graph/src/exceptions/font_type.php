<?php
/**
 * File containing the ezcGraphUnknownFontTypeException class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if font type is unknown or not supported.
 *
 * @package Graph
 * @version //autogentag//
 */
class ezcGraphUnknownFontTypeException extends ezcGraphException
{
    /**
     * Constructor
     * 
     * @param string $file
     * @param string $extension
     * @return void
     * @ignore
     */
    public function __construct( $file, $extension )
    {
        parent::__construct( "Unknown font type '{$extension}' of file '{$file}'." );
    }
}

?>
