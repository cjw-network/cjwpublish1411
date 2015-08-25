<?php
/**
 * File containing the ezcConfigurationException class
 *
 * @package Configuration
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown if the current location is not valid. This means it
 * is impossible to read or write using the location values.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationInvalidSuffixException extends ezcConfigurationException
{
    /**
     * Constructs a new ezcConfigurationInvalidSuffixException.
     *
     * @param string $path
     * @param string $expectedSuffix
     * @return void
     */
    function __construct( $path, $expectedSuffix )
    {
        parent::__construct( "The path '{$path}' has an invalid suffix (should be '{$expectedSuffix}')." );
    }
}
?>
