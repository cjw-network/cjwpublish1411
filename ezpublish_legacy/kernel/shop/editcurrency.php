<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$module = $Params['Module'];

$ini = eZINI::instance( 'site.ini' );

$error = false;
$canEdit = true;
$originalCurrencyCode = $Params['Currency'];
$currencyParams = array( 'code' => false,
                         'symbol' => false,
                         'locale' => $ini->variable( 'RegionalSettings', 'Locale' ),
                         'custom_rate_value' => '0.0000',
                         'rate_factor' => '1.0000' );

if ( $module->isCurrentAction( 'Cancel' ) )
{
    return $module->redirectTo( $module->functionURI( 'currencylist' ) );
}
else if ( $module->isCurrentAction( 'Create' ) )
{
    if ( $module->hasActionParameter( 'CurrencyData' ) )
        $currencyParams = $module->actionParameter( 'CurrencyData' );

    if ( $errCode = eZCurrencyData::canCreate( $currencyParams['code'] ) )
    {
        $error = eZCurrencyData::errorMessage( $errCode );
    }
    else
    {
        $error = validateCurrencyData( $currencyParams );
        if ( $error === false )
        {
            eZShopFunctions::createCurrency( $currencyParams );
            eZContentCacheManager::clearAllContentCache();

            return $module->redirectTo( $module->functionURI( 'currencylist' ) );
        }
    }
}
else if ( $module->isCurrentAction( 'StoreChanges' ) )
{
    $originalCurrencyCode = $module->hasActionParameter( 'OriginalCurrencyCode' ) ? $module->actionParameter( 'OriginalCurrencyCode' ) : '';
    if ( $module->hasActionParameter( 'CurrencyData' ) )
        $currencyParams = $module->actionParameter( 'CurrencyData' );

    $errCode = eZShopFunctions::changeCurrency( $originalCurrencyCode, $currencyParams['code'] );
    if ( $errCode === eZCurrencyData::ERROR_OK )
    {
        $error = validateCurrencyData( $currencyParams );
        if ( $error === false )
        {
            $currency = eZCurrencyData::fetch( $currencyParams['code'] );
            if ( is_object( $currency ) )
            {
                $currency->setAttribute( 'symbol', $currencyParams['symbol'] );
                $currency->setAttribute( 'locale', $currencyParams['locale'] );
                $currency->setAttribute( 'custom_rate_value', $currencyParams['custom_rate_value'] );
                $currency->setAttribute( 'rate_factor', $currencyParams['rate_factor'] );

                $db = eZDB::instance();
                $db->begin();
                $currency->sync();
                $db->commit();

                eZContentCacheManager::clearAllContentCache();

                return $module->redirectTo( $module->functionURI( 'currencylist' ) );
            }
            else
            {
                $error = eZCurrencyData::errorMessage( $currency );
            }
        }
    }
    else
    {
        $error = eZCurrencyData::errorMessage( $errCode );
    }
}

$pathText = '';
if ( strlen( $originalCurrencyCode ) > 0 )
{
    // going to edit existing currency
    $pathText = ezpI18n::tr( 'kernel/shop', 'Edit currency' );

    if ( $currencyParams['code'] === false )
    {
        // first time in 'edit' mode? => initialize template variables
        // with existing data.
        $currency = eZCurrencyData::fetch( $originalCurrencyCode );
        if ( is_object( $currency ) )
        {
            $currencyParams['code'] = $currency->attribute( 'code' );
            $currencyParams['symbol'] = $currency->attribute( 'symbol' );
            $currencyParams['locale'] = $currency->attribute( 'locale' );
            $currencyParams['custom_rate_value'] = $currency->attribute( 'custom_rate_value' );
            $currencyParams['rate_factor'] = $currency->attribute( 'rate_factor' );
        }
        else
        {
            $error = "'$originalCurrencyCode' currency  doesn't exist.";
            $canEdit = false;
        }
    }
}
else
{
    // going to create new currency
    $pathText = ezpI18n::tr( 'kernel/shop', 'Create new currency' );
}


$tpl = eZTemplate::factory();

$tpl->setVariable( 'error', $error );
$tpl->setVariable( 'can_edit', $canEdit );
$tpl->setVariable( 'original_currency_code', $originalCurrencyCode );
$tpl->setVariable( 'currency_data', $currencyParams );

$Result = array();
$Result['content'] = $tpl->fetch( "design:shop/editcurrency.tpl" );
$Result['path'] = array( array( 'text' => $pathText,
                                'url' => false ) );

/**
 * Validates currency data:
 *  - checks that custom_rate_value & rate_factor are provided and are floats.
 *
 * @param array $currencyData Currenty data as submitted. Will be modified to
 *        remove invalid values since it is passed by reference
 * @return false|string True if data is valid, an error message if it's not
 */
function validateCurrencyData( &$currencyData )
{
    $return = false;

    $floatValidator = new eZFloatValidator( 0 );
    if ( $floatValidator->validate( $currencyData['custom_rate_value'] ) == eZInputValidator::STATE_INVALID )
    {
        $return = ezpI18n::tr( 'kernel/shop', "'%value' is not a valid custom rate value (positive number expected)",
            'Error message', array( '%value' => $currencyData['custom_rate_value'] ) );
        $currencyData['custom_rate_value'] = '';
    }
    if ( $floatValidator->validate( $currencyData['rate_factor'] ) == eZInputValidator::STATE_INVALID )
    {
        if ( $return === false )
            $return = ezpI18n::tr( 'kernel/shop', "'%value' is not a valid rate_factor value (positive number expected)",
                'Error message', array( '%value' => $currencyData['rate_factor'] ) );
        $currencyData['rate_factor'] = '';
    }

    return $return;
}
?>
