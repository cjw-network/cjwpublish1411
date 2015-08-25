<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

// Parameters: ruleID (optional)

$module = $Params['Module'];

$errors = false;
$errorHeader = false;
$productCategories = eZProductCategory::fetchList();

/**
 * Check entered data.
 *
 * \return list of errors found, or false if the data is ok.
 */
function checkEnteredData( $country, $categories, $vatType, $productCategories, $ruleID )
{
    $errors = false;
    $errorHeader = '';

    /*
     * Check if the data was entered correctly.
     */

    if ( !$country || !is_numeric( $vatType ) )
    {
        $errors = array();
        $errorHeader = ezpI18n::tr( 'kernel/shop/editvatrule', 'Invalid data entered' );

        if ( !$country )
            $errors[] = ezpI18n::tr( 'kernel/shop/editvatrule', 'Choose a country.' );
        if ( !is_numeric( $vatType ) )
            $errors[] = ezpI18n::tr( 'kernel/shop/editvatrule', 'Choose a VAT type.' );

        return array( $errorHeader, $errors );
    }

    /*
     * Check if the rule we're about to create
     * conflicts with existing ones.
     */

    $errorHeader = ezpI18n::tr( 'kernel/shop/editvatrule', 'Conflicting rule' );
    $vatRules = eZVatRule::fetchList();

    // If the rule is default one
    if ( !$categories )
    {
        // check if default rule already exists.
        foreach ( $vatRules as $i )
        {
            if ( $i->attribute( 'id' ) == $ruleID ||
                 $i->attribute( 'country_code' ) != $country ||
                 $i->attribute( 'product_categories' ) )
                continue;

            if ( $country == '*' )
                $errors[] = ezpI18n::tr( 'kernel/shop/editvatrule', 'Default rule for any country already exists.' );
            else
            {
                $errorMessage = "Default rule for country '%1' already exists.";
                $errors[] = ezpI18n::tr( 'kernel/shop/editvatrule', $errorMessage, null, array( $country ) );
            }

            break;
        }
    }

    // If the rule contains some categories
    else
    {
        // check if there are already rules defined for the same country
        // containing some of the categories.

        foreach ( $vatRules as $i )
        {
            if ( $i->attribute( 'id' ) == $ruleID ||
                 $i->attribute( 'country_code' ) != $country ||
                 !$i->attribute( 'product_categories' ) )
                continue;

            $intersection = array_intersect( $categories, $i->attribute( 'product_categories_ids' ) );
            if ( !$intersection )
                continue;

            // Construct string containing name of all the conflicting categories.
            $intersectingCategories = array();
            foreach ( $productCategories as $cat )
            {
                if ( array_search( $cat->attribute( 'id' ), $intersection ) !== false )
                     $intersectingCategories[] = $cat->attribute( 'name' );
            }
            $intersectingCategories = join( ', ', $intersectingCategories );

            if ( $country == '*' )
                $errorMessage = "There is already a rule defined for any country containing the following categories: %2.";
            else
                $errorMessage = "There is already a rule defined for country '%1' containing the following categories: %2.";

            $errors[] = ezpI18n::tr( 'kernel/shop/editvatrule', $errorMessage, null, array( $country, $intersectingCategories ) );
        }
    }

    return array( $errorHeader, $errors );
}


if ( $module->isCurrentAction( 'Cancel' ) )
{
    return $module->redirectTo( $module->functionURI( 'vatrules' ) );
}
else if ( in_array( $module->currentAction(), array(  'Create', 'StoreChanges' ) ) )
{
    if ( $module->isCurrentAction( 'StoreChanges' ) )
        $ruleID = $module->actionParameter( 'RuleID' );

    $chosenCountry = $module->actionParameter( 'Country' );
    $chosenCategories = $module->hasActionParameter( 'Categories' ) ? $module->actionParameter( 'Categories' ) : array();
    $chosenVatType = $module->actionParameter( 'VatType' );

    // normalize data
    if ( in_array( '*', $chosenCategories ) )
        $chosenCategories = array();

    list( $errorHeader, $errors ) = checkEnteredData( $chosenCountry, $chosenCategories, $chosenVatType,
                                                      $productCategories, $ruleID );

    // save rule (creating it if not exists)
    do // one-iteration loop to prevent high nesting levels
    {
        if ( $errors !== false )
            break;

        // The entered data is ok.
        if ( $module->isCurrentAction( 'StoreChanges' ) )
        {
            // Store changes made to the VAT rule.
            $vatRule = eZVatRule::fetch( $ruleID );

            if ( !is_object( $vatRule ) )
            {
                //$ruleID = null;
                $errors[] = ezpI18n::tr( 'kernel/shop/editvatrule', 'Rule not found' );
                break;
            }
        }
        else
        {
            // Create a new VAT rule...
            $vatRule = eZVatRule::create();
        }

        // Modify chosen categories array
        // so that it can be saved into the VAT rule.
        $addID = create_function('$i', "return array( 'id' => \$i ) ;" );
        $chosenCategories = array_map( $addID, $chosenCategories );

        $vatRule->setAttribute( 'country_code', $chosenCountry );
        $vatRule->setAttribute( 'product_categories', $chosenCategories );
        $vatRule->setAttribute( 'vat_type', $chosenVatType );
        $vatRule->store();

        return $module->redirectTo( $module->functionURI( 'vatrules' ) );

    } while ( false );
}

if ( is_numeric( $ruleID ) )
{
    $tplVatRule      = eZVatRule::fetch( $ruleID );
    $tplCountry      = $tplVatRule->attribute( 'country_code' );
    $tplCategoryIDs  = $tplVatRule->attribute( 'product_categories_ids' );
    $tplVatTypeID    = $tplVatRule->attribute( 'vat_type' );

    $pathText = ezpI18n::tr( 'kernel/shop/editvatrule', 'Edit VAT charging rule' );
}
else
{
    $tplVatRule = null;
    $tplCountry = false;
    $tplVatTypeID = false;
    $tplCategoryIDs = array();

    $pathText = ezpI18n::tr( 'kernel/shop/editvatrule', 'Create new VAT charging rule' );
}

if ( $errors !== false )
{
    $tplCountry     = $chosenCountry;
    $tplCategoryIDs = $chosenCategories;
    $tplVatTypeID   = $chosenVatType;
}

$vatTypes = eZVatType::fetchList( true, true );


$tpl = eZTemplate::factory();

$tpl->setVariable( 'error_header', $errorHeader );
$tpl->setVariable( 'errors', $errors );
$tpl->setVariable( 'all_vat_types', $vatTypes );
$tpl->setVariable( 'all_product_categories', $productCategories );

$tpl->setVariable( 'rule',         $tplVatRule );
$tpl->setVariable( 'country_code', $tplCountry );
$tpl->setVariable( 'category_ids', $tplCategoryIDs );
$tpl->setVariable( 'vat_type_id',  $tplVatTypeID );

$Result = array();
$Result['content'] = $tpl->fetch( "design:shop/editvatrule.tpl" );
$Result['path'] = array( array( 'text' => $pathText,
                                'url' => false ) );

?>
