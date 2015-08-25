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
 * Exception that is thrown if the accessed setting is not of the requested
 * type.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationSettingWrongTypeException extends ezcConfigurationException
{
    /**
     * Constructs a new ezcConfigurationSettingWrongTypeException.
     *
     * @param string $groupName
     * @param string $settingName
     * @param string $expectedType
     * @param string $settingType
     * @return void
     */
    function __construct( $groupName, $settingName, $expectedType, $settingType )
    {
        parent::__construct( "The expected type for the setting '{$groupName}', '{$settingName}' is '{$expectedType}'. The setting was of type '{$settingType}'." );
    }
}
?>
