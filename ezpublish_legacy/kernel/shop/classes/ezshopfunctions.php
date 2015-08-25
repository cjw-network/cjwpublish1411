<?php
/**
 * File containing the eZShopFunctions class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

class eZShopFunctions
{
    function eZShopFunctions()
    {
    }

    /*!
     \static
    */
    static function isProductClass( $contentClass )
    {
        $type = eZShopFunctions::productTypeByClass( $contentClass );
        return ( $type !== false );
    }

    /*!
     \static
    */
    static function isProductObject( $contentObject )
    {
        $type = eZShopFunctions::productTypeByObject( $contentObject );
        return ( $type !== false );
    }

    static function isSimplePriceClass( $contentClass )
    {
        $type = eZShopFunctions::productTypeByClass( $contentClass );
        return eZShopFunctions::isSimplePriceProductType( $type );

    }

    static function isSimplePriceProductType( $type )
    {
        return ( $type === 'ezprice' );
    }

    static function isMultiPriceClass( $contentClass )
    {
        $type = eZShopFunctions::productTypeByClass( $contentClass );
        return eZShopFunctions::isMultiPriceProductType( $type );
    }

    static function isMultiPriceProductType( $type )
    {
        return ( $type === 'ezmultiprice' );
    }

    /*!
     \static
    */
    static function productTypeByClass( $contentClass )
    {
        $type = false;

        if ( is_object( $contentClass ) )
        {
            $classAttributes = $contentClass->fetchAttributes();
            foreach ( $classAttributes as $classAttribute )
            {
                $dataType = $classAttribute->attribute( 'data_type_string' );
                if ( eZShopFunctions::isProductDatatype( $dataType ) )
                {
                    return $dataType;
                }
            }
        }

        return $type;
    }

    /*!
     \static
    */
    static function productTypeByObject( $contentObject )
    {
        if ( is_object( $contentObject ) )
        {
            $attributes = $contentObject->contentObjectAttributes();
            foreach ( $attributes as $attribute )
            {
                $dataType = $attribute->dataType();
                if ( eZShopFunctions::isProductDatatype( $dataType->isA() ) )
                {
                    return $dataType->isA();
                }
            }
        }

        return false;
    }

    /*!
     \static
    */
    static function isProductDatatype( $dataTypeString )
    {
        return in_array( $dataTypeString, eZShopFunctions::productDatatypeStringList() );
    }

    /**
     * Since 5.3 you can define a ini variable containing all datatypes having prices.
     * If the setting is not present, function will return a hardcoded list of them
     * like it did before.
     *
     * @return array
     */
    static function productDatatypeStringList()
    {
        $ini = eZINI::instance();
        if ( $ini->hasVariable( 'ShopSettings', 'ProductDatatypeStringList' ) )
            return eZINI::instance()->variable('ShopSettings', 'ProductDatatypeStringList' );

        return array(
            'ezprice',
            'ezmultiprice'
        );
    }

    static function productClassList()
    {
        $productClassList = array();
        $classList = eZContentClass::fetchList();
        foreach ( $classList as $class )
        {
            if ( eZShopFunctions::isProductClass( $class ) )
            {
                $productClassList[] = $class;
            }
        }

        return $productClassList;
    }

    static function priceAttributeIdentifier( $productClass )
    {
        $identifier = '';
        $classAttribute = eZShopFunctions::priceAttribute( $productClass );
        if ( is_object( $classAttribute ) )
            $identifier = $classAttribute->attribute( 'identifier' );

        return $identifier;
    }

    static function priceAttribute( $productClass )
    {
        if ( is_object( $productClass ) )
        {
            foreach ( $productClass->fetchAttributes() as $classAttribute )
            {
                $dataType = $classAttribute->attribute( 'data_type_string' );
                if ( eZShopFunctions::isProductDatatype( $dataType ) )
                {
                    return $classAttribute;
                }
            }
        }

        return false;
    }

    /*!
     \static
    */
    static function preferredCurrencyCode()
    {
        if( !$currencyCode = eZPreferences::value( 'user_preferred_currency' ) )
        {
            $ini = eZINI::instance( 'shop.ini' );
            $currencyCode = $ini->variable( 'CurrencySettings', 'PreferredCurrency' );
        }
        return $currencyCode;
    }

    /*!
     \static
    */
    static function setPreferredCurrencyCode( $currencyCode )
    {
        $error = eZShopFunctions::isPreferredCurrencyValid( $currencyCode );
        if ( $error === eZError::SHOP_OK )
        {
            eZPreferences::setValue( 'user_preferred_currency', $currencyCode );
        }

        return $error;
    }

    /*!
     Get country stored in user object.
     \static
    */
    static function getUserCountry()
    {
        return eZVATManager::getUserCountry( false, false );
    }


    /*!
     Get country stored in user preferences.
     \static
    */
    static function getPreferredUserCountry()
    {
        return eZPreferences::value( 'user_preferred_country' );
    }

    /*!
     Store country to user preferences.
     \static
    */
    static function setPreferredUserCountry( $country )
    {
        eZPreferences::setValue( 'user_preferred_country', $country );

        return eZError::SHOP_OK;
    }

    /*!
     \static
    */
    static function isPreferredCurrencyValid( $currencyCode = false )
    {
        $error = eZError::SHOP_OK;
        if ( $currencyCode === false )
            $currencyCode = eZShopFunctions::preferredCurrencyCode();

        $currency = eZCurrencyData::fetch( $currencyCode );
        if ( $currency )
        {
            if ( !$currency->isActive() )
            {
                $error = eZError::SHOP_PREFERRED_CURRENCY_INACTIVE;
                eZDebug::writeWarning( "Currency '$currencyCode' is inactive.", __METHOD__ );
            }
        }
        else
        {
            $error = eZError::SHOP_PREFERRED_CURRENCY_DOESNOT_EXIST;
            eZDebug::writeWarning( "Currency '$currencyCode' doesn't exist", __METHOD__ );
        }

        return $error;
    }

    /*!
     \static
    */
    static function createCurrency( $currencyParams )
    {
        $currency = eZCurrencyData::create( $currencyParams['code'],
                                            $currencyParams['symbol'],
                                            $currencyParams['locale'],
                                            '0.0000',
                                            $currencyParams['custom_rate_value'],
                                            $currencyParams['rate_factor'] );
        if ( is_object( $currency ) )
        {
            $db = eZDB::instance();
            $db->begin();

            $currency->store();
            eZMultiPriceData::createPriceListForCurrency( $currencyParams['code'] );

            $db->commit();
        }
    }

    static function removeCurrency( $currencyCodeList )
    {
        $db = eZDB::instance();
        $db->begin();

        eZCurrencyData::removeCurrencyList( $currencyCodeList );
        eZMultiPriceData::removePriceListForCurrency( $currencyCodeList );

        $db->commit();
    }

    static function changeCurrency( $oldCurrencyCode, $newCurrencyCode )
    {
        $errCode = eZCurrencyData::ERROR_OK;

        if ( strcmp( $oldCurrencyCode, $newCurrencyCode ) !== 0 )
        {
            $errCode = eZCurrencyData::canCreate( $newCurrencyCode );
            if ( $errCode === eZCurrencyData::ERROR_OK )
            {
                $currency = eZCurrencyData::fetch( $oldCurrencyCode );
                if ( is_object( $currency ) )
                {
                    $db = eZDB::instance();
                    $db->begin();

                    $currency->setAttribute( 'code', $newCurrencyCode );
                    $currency->sync();

                    eZMultiPriceData::changeCurrency( $oldCurrencyCode, $newCurrencyCode );

                    $db->commit();
                }
                else
                {
                    $errCode = eZCurrencyData::ERROR_UNKNOWN;
                }
            }
        }

        return $errCode;
    }

    static function updateAutoprices()
    {
        return eZMultiPriceData::updateAutoprices();
    }

    static function convertAdditionalPrice( $toCurrency, $value )
    {
        if ( $toCurrency == false )
            return $value;

        $converter = eZCurrencyConverter::instance();
        $converter->setRoundingType( eZCurrencyConverter::ROUNDING_TYPE_ROUND );
        $converter->setRoundingPrecision( 2 );
        $converter->setRoundingTarget( false );

        return $converter->convertFromLocaleCurrency( $toCurrency, $value, true );
    }

    static function updateAutoRates()
    {
        $error = array( 'code' => eZExchangeRatesUpdateHandler::OK,
                        'description' => '' );

        $handler = eZExchangeRatesUpdateHandler::create();
        if ( $handler )
        {
            $error = $handler->requestRates();
            if ( $error['code'] === eZExchangeRatesUpdateHandler::OK )
            {
                $rateList = $handler->rateList();
                if ( is_array( $rateList ) && count( $rateList ) > 0 )
                {
                    $handlerBaseCurrency = $handler->baseCurrency();
                    if ( $handlerBaseCurrency )
                    {
                        $shopBaseCurrency = false;
                        $shopINI = eZINI::instance( 'shop.ini' );
                        if ( $shopINI->hasVariable( 'ExchangeRatesSettings', 'BaseCurrency' ) )
                            $shopBaseCurrency = $shopINI->variable( 'ExchangeRatesSettings', 'BaseCurrency' );

                        if ( !$shopBaseCurrency )
                            $shopBaseCurrency = $handlerBaseCurrency;

                        // update rates for existing currencies
                        //$baseCurrencyCode = $handler->baseCurrency();
                        if ( isset( $rateList[$shopBaseCurrency] ) || ( $shopBaseCurrency === $handlerBaseCurrency ) )
                        {
                            // to avoid unnecessary multiplication set $crossBaseRate to 'false';
                            $crossBaseRate = false;
                            if ( $shopBaseCurrency !== $handlerBaseCurrency )
                            {
                                $crossBaseRate = 1.0 / (float)$rateList[$shopBaseCurrency];
                                $rateList[$handlerBaseCurrency] = '1.0000';
                            }

                            $currencyList = eZCurrencyData::fetchList();
                            if ( is_array( $currencyList ) && count( $currencyList ) > 0 )
                            {


                                foreach ( $currencyList as $currency )
                                {
                                    $rateValue = false;
                                    $currencyCode = $currency->attribute( 'code' );
                                    if ( isset( $rateList[$currencyCode] ) )
                                    {
                                        $rateValue = $rateList[$currencyCode];
                                        if ( $crossBaseRate !== false )
                                            $rateValue *= $crossBaseRate;
                                    }
                                    else if ( $currencyCode === $shopBaseCurrency )
                                    {
                                        $rateValue = '1.0000';
                                    }

                                    $currency->setAttribute( 'auto_rate_value', $rateValue );
                                    $currency->sync();
                                }
                            }

                            $error['code'] = eZExchangeRatesUpdateHandler::OK;
                            $error['description'] = ezpI18n::tr( 'kernel/shop', "'Auto' rates were updated successfully." );
                        }
                        else
                        {
                            $error['code'] = eZExchangeRatesUpdateHandler::INVALID_BASE_CROSS_RATE;
                            $error['description'] = ezpI18n::tr( 'kernel/shop', "Unable to calculate cross-rate for currency-pair '%1'/'%2'", null, array( $handlerBaseCurrency, $shopBaseCurrency ) );
                        }
                    }
                    else
                    {
                        $error['code'] = eZExchangeRatesUpdateHandler::UNKNOWN_BASE_CURRENCY;
                        $error['description'] = ezpI18n::tr( 'kernel/shop', 'Unable to determine currency for retrieved rates.' );
                    }
                }
                else
                {
                    $error['code'] = eZExchangeRatesUpdateHandler::EMPTY_RATE_LIST;
                    $error['description'] = ezpI18n::tr( 'kernel/shop', 'Retrieved empty list of rates.' );
                }
            }
        }
        else
        {
            $error['code'] = eZExchangeRatesUpdateHandler::CANT_CREATE_HANDLER;
            $error['description'] = ezpI18n::tr( 'kernel/shop', 'Unable to create handler to update auto rates.' );

        }

        if ( $error['code'] !== eZExchangeRatesUpdateHandler::OK )
        {
            eZDebug::writeError( $error['description'], __METHOD__ );
        }

        return $error;
    }
}

?>
