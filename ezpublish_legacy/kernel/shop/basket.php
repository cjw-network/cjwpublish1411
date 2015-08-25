<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$http = eZHTTPTool::instance();
$module = $Params['Module'];


$basket = eZBasket::currentBasket();
$basket->updatePrices(); // Update the prices. Transaction not necessary.


if ( $http->hasPostVariable( "ActionAddToBasket" ) )
{
    $objectID = $http->postVariable( "ContentObjectID" );

    if ( $http->hasPostVariable( "Quantity" ) )
    {
        $quantity = (int)$http->postVariable( "Quantity" );
        if ( $quantity <= 0 )
        {
            $quantity = 1;
        }
    }
    else
    {
        $quantity = 1;
    }

    if ( $http->hasPostVariable( 'eZOption' ) )
        $optionList = $http->postVariable( 'eZOption' );
    else
        $optionList = array();

    $fromPage = '';
    if ( $http->hasSessionVariable( 'LastAccessesURI' ) )
    {
        $fromPage = $http->sessionVariable( 'LastAccessesURI' );
    }
    else
    {
        $fromPage = eZSys::serverVariable ( 'HTTP_REFERER', true );
    }
    $http->setSessionVariable( "FromPage", $fromPage );
    $http->setSessionVariable( "AddToBasket_OptionList_" . $objectID, $optionList );

    $module->redirectTo( "/shop/add/" . $objectID . "/" . $quantity );
    return;
}

if ( $http->hasPostVariable( "RemoveProductItemButton" ) )
{
    $itemCountList = $http->postVariable( "ProductItemCountList" );
    $itemIDList = $http->postVariable( "ProductItemIDList" );

    if ( is_array( $itemCountList ) && is_array( $itemIDList ) && count( $itemCountList ) == count( $itemIDList ) && is_object( $basket ) )
    {
        $productCollectionID = $basket->attribute( 'productcollection_id' );
        $removeItem = $http->postVariable( "RemoveProductItemButton" );
        if ( $http->hasPostVariable( "RemoveProductItemDeleteList" ) )
            $itemList = $http->postVariable( "RemoveProductItemDeleteList" );
        else
            $itemList = array();

        $i = 0;

        $db = eZDB::instance();
        $db->begin();
        $itemCountError = false;
        foreach ( $itemIDList as $id )
        {
            $item = eZProductCollectionItem::fetch( $id );
            if ( is_object( $item ) && $item->attribute( 'productcollection_id' ) == $productCollectionID )
            {
                if ( is_numeric( $itemCountList[$i] ) and $itemCountList[$i] > 0 )
                {
                    $item->setAttribute( "item_count", $itemCountList[$i] );
                    $item->store();
                }
                else
                {
                    if ( ( is_numeric( $removeItem ) and $id != $removeItem ) or ( is_array( $itemList ) and !in_array( $id, $itemList ) ) )
                        $itemCountError = true;
                }
            }
            $i++;
        }
        if ( is_numeric( $removeItem )  )
        {
            $basket->removeItem( $removeItem );
        }
        else
        {
            foreach ( $itemList as $item )
            {
                $basket->removeItem( $item );
            }
        }

        // Update shipping info after removing an item from the basket.
        eZShippingManager::updateShippingInfo( $basket->attribute( 'productcollection_id' ) );

        $db->commit();

        if ( $itemCountError )
        {
            $module->redirectTo( $module->functionURI( "basket" ) . "/(error)/invaliditemcount" );
            return;
        }

        $module->redirectTo( $module->functionURI( "basket" ) . "/" );
        return;
    }
}

if ( $http->hasPostVariable( "StoreChangesButton" ) )
{
    $itemCountList = $http->postVariable( "ProductItemCountList" );
    $itemIDList = $http->postVariable( "ProductItemIDList" );

    // We should check item count, all itemcounts must be greater than 0
    foreach ( $itemCountList as $itemCount )
    {
        // If item count of product <= 0 we should show the error
        if ( !is_numeric( $itemCount ) or $itemCount < 0 )
        {
            // Redirect to basket
            $module->redirectTo( $module->functionURI( "basket" ) . "/(error)/invaliditemcount" );
            return;
        }
    }

    $http->setSessionVariable( 'ProductItemCountList', $itemCountList );
    $http->setSessionVariable( 'ProductItemIDList', $itemIDList );

    $module->redirectTo( '/shop/updatebasket/' );
    return;
}

if ( $http->hasPostVariable( "ContinueShoppingButton" ) )
{
    $itemCountList = $http->hasPostVariable( "ProductItemCountList" ) ? $http->postVariable( "ProductItemCountList" ) : false;
    $itemIDList = $http->hasPostVariable( "ProductItemIDList" ) ? $http->postVariable( "ProductItemIDList" ) : false;
    if ( is_array( $itemCountList ) && is_array( $itemIDList ) && count( $itemCountList ) == count( $itemIDList ) && is_object( $basket ) )
    {
        $productCollectionID = $basket->attribute( 'productcollection_id' );

        $i = 0;

        $db = eZDB::instance();
        $db->begin();
        $itemCountError = false;
        foreach ( $itemIDList as $id )
        {
            if ( !is_numeric( $itemCountList[$i] ) or $itemCountList[$i] <= 0 )
            {
                $itemCountError = true;
            }
            else
            {
                $item = eZProductCollectionItem::fetch( $id );
                if ( is_object( $item ) && $item->attribute( 'productcollection_id' ) == $productCollectionID )
                {
                    $item->setAttribute( "item_count", $itemCountList[$i] );
                    $item->store();
                }
            }
            $i++;
        }
        $db->commit();
        if ( $itemCountError )
        {
            // Redirect to basket
            $module->redirectTo( $module->functionURI( "basket" ) . "/(error)/invaliditemcount" );
            return;
        }
    }
    $fromURL = $http->sessionVariable( "FromPage" );
    $http->RemoveSessionVariable( "FromPage" );
    $module->redirectTo( $fromURL );
    return;
}

$doCheckout = false;
if ( $http->hasSessionVariable( 'DoCheckoutAutomatically' ) )
{
    if ( $http->sessionVariable( 'DoCheckoutAutomatically' ) === true )
    {
        $doCheckout = true;
        $http->setSessionVariable( 'DoCheckoutAutomatically', false );
    }
}

$removedItems = array();

if ( $http->hasPostVariable( "CheckoutButton" ) or ( $doCheckout === true ) )
{
    if ( $http->hasPostVariable( "ProductItemIDList" ) )
    {
        $itemCountList = $http->postVariable( "ProductItemCountList" );

        $counteditems = 0;
        foreach ($itemCountList as $itemCount)
        {
            $counteditems = $counteditems + $itemCount;
        }
        $zeroproduct = false;
        if ( $counteditems == 0 )
        {
            $zeroproduct = true;
            return $module->redirectTo( $module->functionURI( "basket" ) );
        }

        $itemIDList = $http->postVariable( "ProductItemIDList" );

        if ( is_array( $itemCountList ) && is_array( $itemIDList ) && count( $itemCountList ) == count( $itemIDList ) && is_object( $basket ) )
        {
            $productCollectionID = $basket->attribute( 'productcollection_id' );
            $db = eZDB::instance();
            $db->begin();

            for ( $i = 0, $itemCountError = false; $i < count( $itemIDList ); ++$i )
            {
                // If item count of product <= 0 we should show the error
                if ( !is_numeric( $itemCountList[$i] ) or $itemCountList[$i] <= 0 )
                {
                    $itemCountError = true;
                    continue;
                }
                $item = eZProductCollectionItem::fetch( $itemIDList[$i] );
                if ( is_object( $item ) && $item->attribute( 'productcollection_id' ) == $productCollectionID )
                {
                    $item->setAttribute( "item_count", $itemCountList[$i] );
                    $item->store();
                }
            }
            $db->commit();
            if ( $itemCountError )
            {
                // Redirect to basket
                $module->redirectTo( $module->functionURI( "basket" ) . "/(error)/invaliditemcount" );
                return;
            }
        }
    }

    // Fetch the shop account handler
    $accountHandler = eZShopAccountHandler::instance();

    // Do we have all the information we need to start the checkout
    if ( !$accountHandler->verifyAccountInformation() )
    {
        // Fetches the account information, normally done with a redirect
        $accountHandler->fetchAccountInformation( $module );
        return;
    }
    else
    {
        // Creates an order and redirects
        $basket = eZBasket::currentBasket();
        $productCollectionID = $basket->attribute( 'productcollection_id' );

        $verifyResult = eZProductCollection::verify( $productCollectionID  );

        $db = eZDB::instance();
        $db->begin();
        $basket->updatePrices();

        if ( $verifyResult === true )
        {
            $order = $basket->createOrder();
            $order->setAttribute( 'account_identifier', "default" );
            $order->store();

            $http->setSessionVariable( 'MyTemporaryOrderID', $order->attribute( 'id' ) );

            $db->commit();
            $module->redirectTo( '/shop/confirmorder/' );
            return;
        }
        else
        {
            $basket = eZBasket::currentBasket();
            $removedItems = array();
            foreach ( $itemList as $item )
            {
                $removedItems[] = $item;
                $basket->removeItem( $item->attribute( 'id' ) );
            }
        }
        $db->commit();
    }
}
$basket = eZBasket::currentBasket();

$tpl = eZTemplate::factory();
if ( isset( $Params['Error'] ) )
{
    $tpl->setVariable( 'error', $Params['Error'] );
    if ( $Params['Error'] == 'options' )
    {
        $tpl->setVariable( 'error_data', $http->sessionVariable( 'BasketError') );
        $http->removeSessionVariable( 'BasketError');
    }
}
$tpl->setVariable( "removed_items", $removedItems);
$tpl->setVariable( "basket", $basket );
$tpl->setVariable( "module_name", 'shop' );
$tpl->setVariable( "vat_is_known", $basket->isVATKnown() );


// Add shipping cost to the total items price and store the sum to corresponding template vars.
$shippingInfo = eZShippingManager::getShippingInfo( $basket->attribute( 'productcollection_id' ) );
if ( $shippingInfo !== null )
{
    // to make backwards compability with old version, allways set the cost inclusive vat.
    if ( ( isset( $shippingInfo['is_vat_inc'] ) and $shippingInfo['is_vat_inc'] == 0 ) or
         !isset( $shippingInfo['is_vat_inc'] ) )
    {
        $additionalShippingValues = eZShippingManager::vatPriceInfo( $shippingInfo );
        $shippingInfo['cost'] = $additionalShippingValues['total_shipping_inc_vat'];
        $shippingInfo['is_vat_inc'] = 1;
    }

    $totalIncShippingExVat  = $basket->attribute( 'total_ex_vat'  ) + $shippingInfo['cost'];
    $totalIncShippingIncVat = $basket->attribute( 'total_inc_vat' ) + $shippingInfo['cost'];

    $tpl->setVariable( 'shipping_info', $shippingInfo );
    $tpl->setVariable( 'total_inc_shipping_ex_vat', $totalIncShippingExVat );
    $tpl->setVariable( 'total_inc_shipping_inc_vat', $totalIncShippingIncVat );
}

$Result = array();
$Result['content'] = $tpl->fetch( "design:shop/basket.tpl" );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'kernel/shop', 'Basket' ) ) );
?>
