<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$http = eZHTTPTool::instance();
$module = $Params['Module'];
$offset = $Params['Offset'];

if ( !eZUser::isCurrentUserRegistered() )
    return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );

if ( $http->hasPostVariable( "ActionAddToWishList" ) )
{
    $objectID = $http->postVariable( "ContentObjectID" );
    $object = eZContentObject::fetch( $objectID );
    if ( $http->hasPostVariable( 'eZOption' ) )
        $optionList = $http->postVariable( 'eZOption' );
    else
        $optionList = array();

    //$price = 0.0;
    //$isVATIncluded = true;
    //$attributes = $object->contentObjectAttributes();
    //foreach ( $attributes as $attribute )
    //{
    //    $dataType = $attribute->dataType();
    //
    //    if ( $dataType->isA() == "ezprice" )
    //    {
    //        $content = $attribute->content();
    //        $price += $content->attribute( 'price' );
    //        $priceObj = $content;
    //    }
    //}

    $wishList = eZWishList::currentWishList();

    /* Find out, if the item with the same options is not already in the wishlist: */
    $itemID = false;
    $collection = eZProductCollection::fetch( $wishList->attribute( 'productcollection_id' ) );
    if ( $collection )
    {
        $count = 0;
        /* Calculate number of options passed via the HTTP variable: */
        foreach ( array_keys( $optionList ) as $key )
        {
            if ( is_array( $optionList[$key] ) )
                $count += count( $optionList[$key] );
            else
                $count++;
        }
        $collectionItems = $collection->itemList( false );
        foreach ( $collectionItems as $item )
        {
            /* For all items in the wishlist which have the same object_id: */
            if ( $item['contentobject_id'] == $objectID )
            {
                $options = eZProductCollectionItemOption::fetchList( $item['id'], false );
                /* If the number of option for this item is not the same as in the HTTP variable: */
                if ( count( $options ) != $count )
                {
                    break;
                }
                $theSame = true;
                foreach ( $options as $option )
                {
                    /* If any option differs, go away: */
                    if ( ( is_array( $optionList[$option['object_attribute_id']] ) &&
                           !in_array( $option['option_item_id'], $optionList[$option['object_attribute_id']] ) )
                      || ( !is_array( $optionList[$option['object_attribute_id']] ) &&
                           $option['option_item_id'] != $optionList[$option['object_attribute_id']] ) )
                    {
                        $theSame = false;
                        break;
                    }
                }
                if ( $theSame )
                {
                    $itemID = $item['id'];
                    break;
                }
            }
        }
    }

    if ( $itemID == false )
    {
        $item = eZProductCollectionItem::create( $wishList->attribute( "productcollection_id" ) );

        $item->setAttribute( 'name', $object->attribute( 'name' ) );
        $item->setAttribute( "contentobject_id", $objectID );
        $item->setAttribute( "item_count", 1 );
        //$item->setAttribute( "price", $price );


        $db = eZDB::instance();
        $db->begin();

        $item->store();

        //if ( $priceObj->attribute( 'is_vat_included' ) )
        //{
        //    $item->setAttribute( "is_vat_inc", '1' );
        //}
        //else
        //{
        //    $item->setAttribute( "is_vat_inc", '0' );
        //}
        //$item->setAttribute( "vat_value", $priceObj->attribute( 'vat_percent' ) );
        //$item->setAttribute( "discount", $priceObj->attribute( 'discount_percent' ) );
        $item->store();
        //$priceWithoutOptions = $price;

        $optionIDList = array();
        foreach ( array_keys( $optionList ) as $key )
        {
            $attributeID = $key;
            $optionString = $optionList[$key];
            if ( is_array( $optionString ) )
            {
                foreach ( $optionString as $optionID )
                {
                    $optionIDList[] = array( 'attribute_id' => $attributeID,
                                             'option_string' => $optionID );
                }
            }
            else
            {
                $optionIDList[] = array( 'attribute_id' => $attributeID,
                                         'option_string' => $optionString );
            }
        }

        foreach ( $optionIDList as $optionIDItem )
        {
            $attributeID = $optionIDItem['attribute_id'];
            $optionString = $optionIDItem['option_string'];

            $attribute = eZContentObjectAttribute::fetch( $attributeID, $object->attribute( 'current_version' ) );
            $dataType = $attribute->dataType();
            $optionData = $dataType->productOptionInformation( $attribute, $optionString, $item );
            if ( $optionData )
            {
                $optionItem = eZProductCollectionItemOption::create( $item->attribute( 'id' ), $optionData['id'], $optionData['name'],
                //                                                      $optionData['value'], $optionData['additional_price'], $attributeID );
                                                                      $optionData['value'], 0, $attributeID );
                $optionItem->store();
                //$price += $optionData['additional_price'];
            }
        }
        $db->commit();

        //if ( $price != $priceWithoutOptions )
        //{
        //    $item->setAttribute( "price", $price );
        //    $item->store();
        //}
    }

    $module->redirectTo( $module->functionURI( "wishlist" ) . "/" );
    return;
}

if ( $http->hasPostVariable( "RemoveProductItemButton" ) )
{
    $itemList = $http->postVariable( "RemoveProductItemDeleteList" );

    $wishList = eZWishList::currentWishList();

    $db = eZDB::instance();
    $db->begin();
    foreach ( $itemList as $item )
    {
        $wishList->removeItem( $item );
    }
    $db->commit();
    $module->redirectTo( $module->functionURI( "wishlist" ) . "/" );
    return;
}

if ( $http->hasPostVariable( "StoreChangesButton" ) )
{
    $wishList = eZWishList::currentWishList();
    $collection = eZProductCollection::fetch( $wishList->attribute( 'productcollection_id' ) );
    if ( $collection and $http->hasPostVariable( "ProductItemIDList" ) )
    {
        $collectionItems = $collection->itemList();
        $productItemIDlist = $http->postVariable( "ProductItemIDList" );
        $productItemCountList = $http->hasPostVariable( "ProductItemCountList" ) ? $http->postVariable( "ProductItemCountList" ) : false;
        if ( $productItemCountList == false )
        {
           $module->redirectTo( $module->functionURI( "wishlist" ) . "/" );
           return;
        }
        $productItemsCount = array();
        // Create array of productItemID (as index) and productItemCount (as value)
        foreach ( $productItemIDlist as $key => $productItemID )
        {
            if ( isset( $productItemCountList[$key] ) )
                $productItemsCount[$productItemID] = $productItemCountList[$key];
        }
        $db = eZDB::instance();
        $db->begin();
        foreach ( $collectionItems as $item )
        {
            $itemID = $item->attribute( 'id' );
            if ( isset( $productItemsCount[$itemID] ) )
            {
                $item->setAttribute( 'item_count', $productItemsCount[$itemID] );
                $item->store();
            }
        }
        $db->commit();
        $module->redirectTo( $module->functionURI( "wishlist" ) . "/" );
        return;
    }
}


$tpl = eZTemplate::factory();

$wishList = eZWishList::currentWishList();

$tpl->setVariable( "wish_list", $wishList );

$viewParameters = array( 'offset' => $offset );
$tpl->setVariable( 'view_parameters', $viewParameters );

$Result = array();
$Result['content'] = $tpl->fetch( "design:shop/wishlist.tpl" );
$Result['path'] = array( array( 'url' => false,
                                'text' => ezpI18n::tr( 'kernel/shop', 'Wishlist' ) ) );

?>
