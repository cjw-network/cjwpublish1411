<?php
/**
 * File containing the ezpRestProvider class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

class ezpRestProvider
{
    /**
     * @var ezpRestProviderInterface The REST provider object container
     */
    protected static $provider = null;

    protected static $providerName = null;

    const DEFAULT_PROVIDER = 'ezp';

    /**
     * @param string $provider
     * @return ezpRestProviderInterface
     */
    protected static function createProvider( $provider )
    {
        $providerOptions = new ezpExtensionOptions();
        $providerOptions->iniFile = 'rest.ini';
        $providerOptions->iniSection = 'ApiProvider';
        $providerOptions->iniVariable = 'ProviderClass';
        $providerOptions->handlerIndex = $provider;

        $providerInstance = eZExtension::getHandlerClass( $providerOptions );

        if ( !( $providerInstance instanceof ezpRestProviderInterface ) )
            throw new ezpRestProviderNotFoundException( $provider );

        return $providerInstance;
    }

    /**
     * @static
     * @return bool|ezpRestProviderInterface
     */
    public static function getProvider( $provider )
    {
        // If no provider has been given, we fall back to built-in 'ezp' provider.
        // Note: empty string is not a valid input.
        if ( empty( $provider ) )
        {
            $provider = self::DEFAULT_PROVIDER;
        }

        // Check if we already have a provider object for this provider
        // As there can be internal redirects, we also check if the provider name is the same
        if ( !( self::$provider instanceof ezpRestProviderInterface ) || $provider != self::$providerName )
        {
            self::$provider = self::createProvider( $provider );
            self::$providerName = $provider;
        }

        return self::$provider;
    }
}
