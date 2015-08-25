<?php
/**
 * File containing the eZVATManager class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZVATManager ezvatmanager.php
  \brief The class eZVATManager does

*/

class eZVATManager
{
    /**
     * Get percentage of VAT type corresponding to the given product and country the user is from.
     *
     * \return Percentage, or null on error.
     * \public
     * \static
     */
    static function getVAT( $object, $country )
    {
        // Load VAT handler.
        if ( !is_object( $handler = eZVATManager::loadVATHandler() ) )
        {
            if ( $handler === true )
            {
                eZDebug::writeWarning( "No VAT handler specified but dynamic VAT charging is used." );
            }

            return null;
        }

        // Check if user country must be specified.
        $requireUserCountry = eZVATManager::isUserCountryRequired();

        // Determine user country if it's not specified
        if ( $country === false )
            $country = eZVATManager::getUserCountry();

        if ( !$country && $requireUserCountry )
        {
            eZDebug::writeNotice( "User country is not specified." );
        }

        return $handler->getVatPercent( $object, $country );
    }

    /**
     * Check if users must have country specified.
     *
     * \public
     * \static
     */
    static function isUserCountryRequired()
    {
        // Check if user country must be specified.
        $requireUserCountry = true;
        $shopINI = eZINI::instance( 'shop.ini' );
        if ( $shopINI->hasVariable( 'VATSettings', 'RequireUserCountry' ) )
            $requireUserCountry = ( $shopINI->variable( 'VATSettings', 'RequireUserCountry' ) == 'true' );
        return $requireUserCountry;
    }

    /**
     * Determine name of content attribute that contains user's country.
     *
     * \private
     * \static
     */
    static function getUserCountryAttributeName( $requireUserCountry )
    {
        $ini = eZINI::instance( 'shop.ini' );
        if ( !$ini->hasVariable( 'VATSettings', 'UserCountryAttribute' ) )
        {
            if ( $requireUserCountry )
            {
                eZDebug::writeError( "Cannot find user country: please specify its attribute identifier " .
                                       "in the following setting: shop.ini.[VATSettings].UserCountryAttribute",
                                     __METHOD__ );
            }
            return null;
        }

        $countryAttributeName = $ini->variable( 'VATSettings', 'UserCountryAttribute' );
        if ( !$countryAttributeName )
        {
            if ( $requireUserCountry )
            {
                eZDebug::writeError( "Cannot find user country: empty attribute name specified " .
                                       "in the following setting: shop.ini.[VATSettings].UserCountryAttribute",
                                     __METHOD__ );
            }

            return null;
        }

        return $countryAttributeName;
    }

    /**
     * Determine user's country.
     *
     * \public
     * \static
     */
    static function getUserCountry( $user = false, $considerPreferedCountry = true )
    {
        $requireUserCountry = eZVATManager::isUserCountryRequired();

        // If current user has set his/her preferred country via the toolbar
        if ( $considerPreferedCountry )
        {
            // return it
            $country = eZShopFunctions::getPreferredUserCountry();
            if ( $country )
            {
                eZDebug::writeDebug( "Applying user's preferred country <$country> while charging VAT" );
                return $country;
            }
        }

        // Otherwise fetch country saved in the user object.

        if ( $user === false )
        {
            $user = eZUser::currentUser();
        }

        $userObject = $user->attribute( 'contentobject' );
        $countryAttributeName = eZVATManager::getUserCountryAttributeName( $requireUserCountry );

        if ( $countryAttributeName === null )
            return null;

        $userDataMap = $userObject->attribute( 'data_map' );
        if ( !isset( $userDataMap[$countryAttributeName] ) )
        {
            if ( $requireUserCountry )
            {
                eZDebug::writeError( "Cannot find user country: there is no attribute '$countryAttributeName' in object '" .
                                       $userObject->attribute( 'name' ) .
                                       "' of class '" .
                                       $userObject->attribute( 'class_name' ) . "'.",
                                     __METHOD__ );
            }
            return null;
        }

        $countryAttribute = $userDataMap[$countryAttributeName];
        $countryContent = $countryAttribute->attribute( 'content' );

        if ( $countryContent === null )
        {
            if ( $requireUserCountry )
            {
                eZDebug::writeError( "User country is not specified in object '" .
                                       $userObject->attribute( 'name' ) .
                                       "' of class '" .
                                       $userObject->attribute( 'class_name' ) . "'." ,
                                     __METHOD__ );
            }
            return null;
        }

        if ( is_object( $countryContent ) )
            $country = $countryContent->attribute( 'value' );
        elseif ( is_array( $countryContent ) )
        {
            if ( is_array( $countryContent['value'] ) )
            {
                foreach ( $countryContent['value'] as $item )
                {
                    $country = $item['Alpha2'];
                    break;
                }
            }
            else
            {
                $country = $countryContent['value'];
            }
        }
        else
        {
            if ( $requireUserCountry )
            {
                eZDebug::writeError( "User country is not specified or specified incorrectly in object '" .
                                       $userObject->attribute( 'name' ) .
                                       "' of class '" .
                                       $userObject->attribute( 'class_name' ) . "'." ,
                                     __METHOD__ );
            }
            return null;
        }

        return $country;
    }

    /**
     * Set user's country.
     *
     * \public
     * \static
     */
    static function setUserCountry( $user, $country )
    {
        $userObject = $user->attribute( 'contentobject' );
        $requireUserCountry = eZVATManager::isUserCountryRequired();
        $countryAttributeName = eZVATManager::getUserCountryAttributeName( $requireUserCountry );
        if ( $countryAttributeName === null )
        {
            return false;
        }

        $userDataMap = $userObject->attribute( 'data_map' );
        if ( !isset( $userDataMap[$countryAttributeName] ) )
        {
            if ( $requireUserCountry )
            {
                eZDebug::writeError( "Cannot set user country: there is no attribute '$countryAttributeName' in object '" .
                                       $userObject->attribute( 'name' ) .
                                       "' of class '" .
                                       $userObject->attribute( 'class_name' ) . "'.",
                                     __METHOD__ );
            }

            return false;
        }

        eZDebug::writeNotice( sprintf( "Saving country '%s' for user '%s'",
                                       $country, $user->attribute( 'login' ) ) );

        $countryAttribute = $userDataMap[$countryAttributeName];
        $countryAttributeContent = $countryAttribute->content();
        if ( is_array( $countryAttributeContent ) )
            $countryAttributeContent['value'] = $country;
        elseif ( is_object( $countryAttributeContent ) )
            $countryAttributeContent->setAttribute( 'value', $country );
        // not sure that this line is needed since content is returned by reference
        $countryAttribute->setContent( $countryAttributeContent );
        $countryAttribute->store();

        return true;
    }


    /*!
     \return true if a VAT handler is specified in the ini setting, false otherwise.
     */
    static function isDynamicVatChargingEnabled()
    {
        if ( isset( $GLOBALS['eZVATManager_isDynamicVatChargingEnabled'] ) )
            return $GLOBALS['eZVATManager_isDynamicVatChargingEnabled'];

        $enabled = is_object( eZVATManager::loadVATHandler() );
        $GLOBALS['eZVATManager_isDynamicVatChargingEnabled'] = $enabled;
        return $enabled;
    }

    /*!
     Load VAT handler (if specified).

     \private
     \static
     \return true if no handler specified,
             false if a handler specified but could not be loaded,
             handler object if handler specified and found.
     */
    static function loadVATHandler()
    {
        // FIXME: cache loaded handler.

        $shopINI = eZINI::instance( 'shop.ini' );

        if ( !$shopINI->hasVariable( 'VATSettings', 'Handler' ) )
            return true;

        $handlerName = $shopINI->variable( 'VATSettings', 'Handler' );
        $repositoryDirectories = $shopINI->variable( 'VATSettings', 'RepositoryDirectories' );
        $extensionDirectories = $shopINI->variable( 'VATSettings', 'ExtensionDirectories' );

        $baseDirectory = eZExtension::baseDirectory();
        foreach ( $extensionDirectories as $extensionDirectory )
        {
            $extensionPath = $baseDirectory . '/' . $extensionDirectory . '/vathandlers';
            if ( file_exists( $extensionPath ) )
                $repositoryDirectories[] = $extensionPath;
        }

        $foundHandler = false;
        foreach ( $repositoryDirectories as $repositoryDirectory )
        {
            $includeFile = "$repositoryDirectory/{$handlerName}vathandler.php";

            if ( file_exists( $includeFile ) )
            {
                $foundHandler = true;
                break;
            }
        }

        if ( !$foundHandler )
        {
            eZDebug::writeError( "VAT handler '$handlerName' not found, " .
                                   "searched in these directories: " .
                                   implode( ', ', $repositoryDirectories ),
                                 __METHOD__ );
            return false;
        }

        $className = $handlerName . 'VATHandler';
        return new $className;
    }
}
?>
