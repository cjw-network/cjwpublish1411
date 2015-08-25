<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$module = $Params['Module'];
$offset = $Params['Offset'];

$error = false;

if ( $module->hasActionParameter( 'Offset' ) )
{
    $offset = $module->actionParameter( 'Offset' );
}

if ( $module->isCurrentAction( 'NewCurrency' ) )
{
    $module->redirectTo( $module->functionURI( 'editcurrency' ) );
}
else if ( $module->isCurrentAction( 'RemoveCurrency' ) )
{
    $currencyList = $module->hasActionParameter( 'DeleteCurrencyList' ) ? $module->actionParameter( 'DeleteCurrencyList' ) : array();

    eZShopFunctions::removeCurrency( $currencyList );

    eZContentCacheManager::clearAllContentCache();
}
else if ( $module->isCurrentAction( 'ApplyChanges' ) )
{
    $updateDataList = $module->hasActionParameter( 'CurrencyList' ) ? $module->actionParameter( 'CurrencyList' ) : array();

    $currencyList = eZCurrencyData::fetchList();
    $db = eZDB::instance();
    $db->begin();
    foreach ( $currencyList as $currency )
    {
        $currencyCode = $currency->attribute( 'code' );
        if ( isset( $updateDataList[$currencyCode] ) )
        {
            $updateData = $updateDataList[$currencyCode];

            if ( isset( $updateData['status'] ) )
                $currency->setStatus( $updateData['status'] );

            if ( is_numeric( $updateData['custom_rate_value'] ) )
                $currency->setAttribute( 'custom_rate_value', $updateData['custom_rate_value'] );
            else if ( $updateData['custom_rate_value'] == '' )
                $currency->setAttribute( 'custom_rate_value', 0 );

            if ( is_numeric( $updateData['rate_factor'] ) )
                $currency->setAttribute( 'rate_factor', $updateData['rate_factor'] );
            else if ( $updateData['rate_factor'] == '' )
                $currency->setAttribute( 'rate_factor', 0 );

            $currency->sync();
        }
    }
    $db->commit();

    $error = array( 'code' => 0,
                    'description' => ezpI18n::tr( 'kernel/shop', 'Changes were stored successfully.' ) );
}
else if ( $module->isCurrentAction( 'UpdateAutoprices' ) )
{
    $error = eZShopFunctions::updateAutoprices();

    eZContentCacheManager::clearAllContentCache();
}
else if ( $module->isCurrentAction( 'UpdateAutoRates' ) )
{
    $error = eZShopFunctions::updateAutoRates();
}

if ( $error !== false )
{
    if ( $error['code'] != 0 )
        $error['style'] = 'message-error';
    else
        $error['style'] = 'message-feedback';
}

switch ( eZPreferences::value( 'currencies_list_limit' ) )
{
    case '2': { $limit = 25; } break;
    case '3': { $limit = 50; } break;
    default:  { $limit = 10; } break;
}

// fetch currencies
$currencyList = eZCurrencyData::fetchList( null, true, $offset, $limit );
$currencyCount = eZCurrencyData::fetchListCount();

$viewParameters = array( 'offset' => $offset );

$tpl = eZTemplate::factory();

$tpl->setVariable( 'currency_list', $currencyList );
$tpl->setVariable( 'currency_list_count', $currencyCount );
$tpl->setVariable( 'limit', $limit );
$tpl->setVariable( 'view_parameters', $viewParameters );
$tpl->setVariable( 'show_error_message', $error !== false );
$tpl->setVariable( 'error', $error );

$Result = array();
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/shop', 'Available currency list' ),
                                'url' => false ) );
$Result['content'] = $tpl->fetch( "design:shop/currencylist.tpl" );



?>
