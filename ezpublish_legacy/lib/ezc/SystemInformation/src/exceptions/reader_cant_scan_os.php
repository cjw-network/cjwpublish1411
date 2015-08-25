<?php
/**
 * File containing the ezcSystemInfoReaderCantScanOSException class
 * 
 * @package SystemInformation
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reader can't scan OS for system values exception.
 *
 * Throws when system information source (file, registry, etc.)
 * is not available.
 *
 * @package SystemInformation
 * @version //autogen//
 */
class ezcSystemInfoReaderCantScanOSException extends ezcSystemInfoException
{
    /**
     * Construct a reader can't scan OS exception.
     *
     * @param string $msg
     */
    function __construct( $msg )
    {
        parent::__construct( $msg );
    }
}
?>
