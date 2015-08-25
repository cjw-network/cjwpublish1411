<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/**
 * Find errors in VAT charging rules.
 *
 * \return list of errors, or false if no errors found.
 */
function findErrors( $vatRules )
{
    $errors = false;

    // 1. Check if default rule exists.
    $defaultRuleExists = false;
    foreach ( $vatRules as $rule )
    {
        if ( $rule->attribute( 'country' ) == '*' &&
             !$rule->attribute( 'product_categories' ) )
        {
            $defaultRuleExists = true;
            break;
        }
    }

    if ( !$defaultRuleExists && count( $vatRules ) > 0 )
        $errors[] = ezpI18n::tr( 'kernel/shop/vatrules', 'No default rule found. ' .
                            'Please add rule having "Any" country and "Any" category.' );

    // 2. Check for conflicting rules.
    // Conflicting rules are those having the same country and equal or intersecting categories sets.
    $vatRulesCount = count( $vatRules );
    for ( $i=0; $i < $vatRulesCount; $i++ )
    {
        $iRule       = $vatRules[$i];
        $iCountry    = $iRule->attribute( 'country_code' );
        $iCategories = $iRule->attribute( 'product_categories_names' );

        for ( $j=$i+1; $j < $vatRulesCount; $j++ )
        {
            $jRule       = $vatRules[$j];
            $jCountry    = $jRule->attribute( 'country_code' );

            if ( $iCountry != $jCountry )
                continue;

            $jCategories = $jRule->attribute( 'product_categories_names' );

            // Multiple default rules.
            if ( !$iCategories && !$jCategories )
            {
                if ( $iCountry == '*' )
                {
                    $errorMessage = "Conflict: There are multiple default rules.";
                    $errors[] = ezpI18n::tr( 'kernel/shop/vatrules', $errorMessage );
                }
                else
                {
                    $errorMessage = "Conflict: There are multiple default rules for country '%1'.";
                    $errors[] = ezpI18n::tr( 'kernel/shop/vatrules', $errorMessage, null, array( $iCountry ) );
                }
            }
            // Intersecting rules.
            elseif ( $iCategories && $jCategories && $commonCategories = array_intersect( $iCategories, $jCategories ) )
            {
                if ( $iCountry == '*' )
                {
                    $errorMessage = "Conflict: The following categories for any country are mentioned in multiple rules: %2.";
                    $errors[] = ezpI18n::tr( 'kernel/shop/vatrules', $errorMessage, null, array( $iCountry, join( ',', $commonCategories ) ) );
                }
                else
                {
                    $errorMessage = "Conflict: The following categories for country '%1' are mentioned in multiple rules: %2.";
                    $errors[] = ezpI18n::tr( 'kernel/shop/vatrules', $errorMessage, null, array( $iCountry, join( ',', $commonCategories ) ) );
                }
            }
        }
    }

    if ( is_array( $errors ) )
    {
        // Remove duplicated error messages.
        $errors = array_unique( $errors );
        sort( $errors );
    }

    return $errors;
}

/**
 * Auxiliary function used to sort VAT rules.
 *
 * Rules are sorted by country and categories.
 * Any specific categories list or country is considered less than '*' (Any).
 */
function compareVatRules($a, $b)
{
    // Compare countries.

    $aCountry = $a->attribute( 'country' );
    $bCountry = $b->attribute( 'country' );

    if ( $aCountry != $bCountry )
    {
        if ( $aCountry == '*' )
            return 1;
        if ( $bCountry == '*' )
            return -1;

        return ( $aCountry < $bCountry ? -1 : 1 );
    }

    // Ok, countries are equal. Let's compare categories then.

    if ( $a->attribute( 'product_categories' ) )
        $aCategory = $a->attribute( 'product_categories_string' );
    else
        $aCategory = '*';

    if ( $b->attribute( 'product_categories' ) )
        $bCategory = $b->attribute( 'product_categories_string' );
    else
        $bCategory = '*';

    if ( $aCategory != $bCategory )
    {
        if ( $aCategory == '*' )
            return 1;
        if ( $bCategory == '*' )
            return -1;

        return ( $aCategory < $bCategory ? -1 : 1 );
    }

    return 0;
}

$module = $Params['Module'];
$http   = eZHTTPTool::instance();
$tpl = eZTemplate::factory();

if ( $http->hasPostVariable( "AddRuleButton" ) )
{
    return $module->redirectTo( $module->functionURI( "editvatrule" ) );
}

if ( $http->hasPostVariable( "RemoveRuleButton" ) )
{
    if ( !$http->hasPostVariable( "RuleIDList" ) )
        $ruleIDList = array();
    else
        $ruleIDList = $http->postVariable( "RuleIDList" );

    $db = eZDB::instance();
    $db->begin();
    foreach ( $ruleIDList as $ruleID )
        eZVatRule::removeVatRule( $ruleID );
    $db->commit();
}

if ( $http->hasPostVariable( "SaveCategoriesButton" ) )
{
    $db = eZDB::instance();
    $db->begin();
    foreach ( $productCategories as $cat )
    {
        $id = $cat->attribute( 'id' );

        if ( !$http->hasPostVariable( "category_name_" . $id ) )
            continue;

        $name = $http->postVariable( "category_name_" . $id );
        $cat->setAttribute( 'name', $name );
        $cat->store();
    }
    $db->commit();
    return $module->redirectTo( $module->functionURI( "productcategories" ) );
}

$vatRules = eZVatRule::fetchList();
$errors = findErrors( $vatRules );
usort( $vatRules, 'compareVatRules' );

$tpl->setVariable( 'rules', $vatRules );
$tpl->setVariable( 'errors', $errors );

$path = array();
$path[] = array( 'text' => ezpI18n::tr( 'kernel/shop/vatrules', 'VAT rules' ),
                 'url' => false );

$Result = array();
$Result['path'] = $path;
$Result['content'] = $tpl->fetch( "design:shop/vatrules.tpl" );

?>
