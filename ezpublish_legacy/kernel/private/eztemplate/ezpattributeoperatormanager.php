<?php
/**
 * File containing ezpAttributeOperatorManager class definition
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */
 
class ezpAttributeOperatorManager
{
    /**
     * @var ezpAttributeOperatorFormatterInterface Output formatter object container
     */
    protected static $formatter = null;
    protected static $format = null;

    /**
     * Searches for the output formatter handler class for a given format
     *
     * @static
     * @param string $format
     * @return ezpAttributeOperatorFormatterInterface
     */
    protected static function createFormatter( $format )
    {
        $formatterOptions = new ezpExtensionOptions();
        $formatterOptions->iniFile = 'template.ini';
        $formatterOptions->iniSection = 'AttributeOperator';
        $formatterOptions->iniVariable = 'OutputFormatter';
        $formatterOptions->handlerIndex = $format;

        $formatterInstance = eZExtension::getHandlerClass( $formatterOptions );

        if ( !( $formatterInstance instanceof ezpAttributeOperatorFormatterInterface ) )
            eZDebug::writeError( "Undefined output formatter for '{$format}'", __METHOD__ );

        return $formatterInstance;
    }

    /**
     * Checks is given format has registered handler class
     *
     * @static
     * @param string $format
     * @return bool
     */
    protected static function isRegisteredFormatter( $format )
    {
        return array_key_exists( $format, eZINI::instance( 'template.ini' )->variableArray( 'AttributeOperator', 'OutputFormatter' ) );
    }

    /**
     * Returns formatter object for a given format
     *
     * @static
     * @param string $format
     * @return ezpAttributeOperatorFormatterInterface|null
     */
    public static function getOutputFormatter( $format )
    {
        if ( !self::isRegisteredFormatter( $format ) )
        {
            $format = eZINI::instance( 'template.ini' )->variable( 'AttributeOperator', 'DefaultFormatter' );
        }

        if ( !( self::$formatter instanceof ezpAttributeOperatorFormatterInterface ) || $format != self::$format )
        {
            self::$formatter = self::createFormatter( $format );
            self::$format = $format;
        }

        return self::$formatter;
    }
}
