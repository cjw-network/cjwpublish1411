<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  Apply changes made to categories' names.

  \return errors, empty array if none exists
 */
function applyChanges( $module, $http, $productCategories = false )
{
    $errors = array();
    if ( $productCategories === false )
        $productCategories = eZProductCategory::fetchList();

    $db = eZDB::instance();
    $db->begin();
    foreach ( $productCategories as $cat )
    {
        $id = $cat->attribute( 'id' );

        if ( !$http->hasPostVariable( "category_name_" . $id ) )
            continue;

        $name = $http->postVariable( "category_name_" . $id );

        if ( !$name )
        {
            $errors[] = ezpI18n::tr( 'kernel/shop/productcategories', 'Empty category names are not allowed (corrected).' );
            continue;
        }

        $cat->setAttribute( 'name', $name );
        $cat->store();
    }
    $db->commit();

    return $errors;
}

/**
 * Generate a unique category name.
 *
 * The generated name looks like "Product category X"
 * where X is a unique number.
 */
function generateUniqueCategoryName( $productCategories )
{
    $commonPart = ezpI18n::tr( 'kernel/shop/productcategories', 'Product category' );
    $maxNumber = 0;
    foreach ( $productCategories as $cat )
    {
        $catName = $cat->attribute( 'name' );

        if ( !preg_match( "/^$commonPart (\d+)/", $catName, $matches ) )
            continue;

        $curNumber = $matches[1];
        if ( $curNumber > $maxNumber )
            $maxNumber = $curNumber;
    }

    $maxNumber++;
    return "$commonPart $maxNumber";
}

$module = $Params['Module'];
$http   = eZHTTPTool::instance();
$tpl = eZTemplate::factory();
$errors = false;

// Remove checked categories.
// Will check for categories' dependencies.
// If there are none just removes the categories.
// Otherwise shows confirmation dialog with the dependencies displayed.
if ( $module->isCurrentAction( 'Remove' ) )
{
    $errors = applyChanges( $module, $http );

    if ( !$module->hasActionParameter( 'CategoryIDList' ) )
        $catIDList = array();
    else
        $catIDList = $module->actionParameter( 'CategoryIDList' );

    if ( $catIDList )
    {
        // Find dependencies for the categories being removed.

        $deps = array();
        foreach ( $catIDList as $catID )
        {
            $category = eZProductCategory::fetch( $catID );
            if ( !is_object( $category ) )
                continue;

            $catName  = $category->attribute( 'name' );
            $dependantRulesCount = eZVatRule::fetchCountByCategory( $catID );
            $dependantProductsCount = eZProductCategory::fetchProductCountByCategory( $catID );
            $deps[$catID] = array( 'name' => $catName,
                                   'affected_rules_count'    => $dependantRulesCount,
                                   'affected_products_count' => $dependantProductsCount );
        }

        // Skip the confirmation dialog if the categories
        // being removed have no conflicts.
        $haveDeps = false;
        foreach ( $deps as $dep )
        {
            if ( $dep['affected_rules_count'] > 0 || $dep['affected_products_count'] > 0 )
                $haveDeps = true;
        }

        // Show the confirmation dialog.
        if ( $haveDeps )
        {
            $tpl->setVariable( 'dependencies', $deps );
            $tpl->setVariable( 'category_ids', join( ',', $catIDList ) );
            $path = array( array( 'text' => ezpI18n::tr( 'kernel/shop/productcategories', 'Product categories' ),
                                  'url' => false ) );
            $Result = array();
            $Result['path'] = $path;
            $Result['content'] = $tpl->fetch( "design:shop/removeproductcategories.tpl" );
            return;
        }
        else
        {
            // Pass through.
            $module->setCurrentAction( 'ConfirmRemoval' );
        }

    }
}
// Silently remove specified categories.
if ( $module->isCurrentAction( 'ConfirmRemoval' ) )
{
    if ( !$module->hasActionParameter( 'CategoryIDList' ) )
        $catIDList = array();
    else
    {
        // The list of categories is a string if passed from the confirmation dialog
        // and an array if passed from another action.
        $catIDList = $module->actionParameter( 'CategoryIDList' );
        if ( is_string( $catIDList ) )
            $catIDList = explode( ',', $catIDList );
    }

    $db = eZDB::instance();
    $db->begin();
    foreach ( $catIDList as $catID )
        eZProductCategory::removeByID( (int) $catID );
    $db->commit();
}
// Add new category.
elseif ( $module->isCurrentAction( 'Add' ) )
{
    $productCategories = eZProductCategory::fetchList( true );
    $errors = applyChanges( $module, $http, $productCategories );

    $category = eZProductCategory::create();
    $category->setAttribute( 'name', generateUniqueCategoryName( $productCategories ) );
    $category->store();
    $tpl->setVariable( 'last_added_id', $category->attribute( 'id' ) );
}
// Apply changes made to categories' names.
elseif ( $module->isCurrentAction( 'StoreChanges' ) )
{
    $errors = applyChanges( $module, $http );
}

// (re-)fetch product categoried list to display them in the template
$productCategories = eZProductCategory::fetchList();

if ( is_array( $errors ) )
    $errors = array_unique( $errors );

$tpl->setVariable( 'categories', $productCategories );
$tpl->setVariable( 'errors', $errors );

$path = array();
$path[] = array( 'text' => ezpI18n::tr( 'kernel/shop/productcategories', 'Product categories' ),
                 'url' => false );
$Result = array();
$Result['path'] = $path;
$Result['content'] = $tpl->fetch( "design:shop/productcategories.tpl" );

?>
