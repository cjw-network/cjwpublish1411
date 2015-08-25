<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
 Get search limit
 */
function pageLimit( $searchPageLimit )
{
    switch ( $searchPageLimit )
    {
        case 1:
            return 5;

        case 2:
        default:
            return 10;

        case 3:
            return 20;

        case 4:
            return 30;

        case 5:
            return 50;
    }
}

$http = eZHTTPTool::instance();

$Module = $Params['Module'];
$ViewMode = $Params['ViewMode'];
$Offset = $Params['Offset'];

if ( $ViewMode == 'offset' )
    $ViewMode = '';

$tpl = eZTemplate::factory();

$ini = eZINI::instance();
$useSearchCode = $ini->variable( 'SearchSettings', 'SearchViewHandling' ) == 'default';
$logSearchStats = $ini->variable( 'SearchSettings', 'LogSearchStats' ) == 'enabled';

$searchText = '';
$originalSearchText = '';
$phraseSearchText = '';

if ( !is_numeric( $Offset ) )
    $Offset = 0;

$searchPageLimit = 2;
if ( $http->hasVariable( 'SearchPageLimit' ) )
{
    $searchPageLimit = $http->variable( 'SearchPageLimit' );
}

$pageLimit = pageLimit( $searchPageLimit );

$maximumSearchLimit = $ini->variable( 'SearchSettings', 'MaximumSearchLimit' );
if ( $pageLimit > $maximumSearchLimit )
    $pageLimit = $maximumSearchLimit;

if ( $http->hasVariable( 'PhraseSearchText' ) and trim( $http->variable( 'PhraseSearchText' ) ) != '' )
{
    $searchText = '"' . $http->variable( 'PhraseSearchText' ) . '"';
    $phraseSearchText = $http->variable( 'PhraseSearchText' );
}

$fullSearchText = '';
if ( $http->hasVariable( 'SearchText' ) )
{
    if ( $searchText != '' )
        $searchText .= ' ';
    $originalSearchText = $http->variable( 'SearchText' );
    $searchText .= $originalSearchText;
    $fullSearchText = $http->variable( 'SearchText' );
}

$searchContentClassID = -1;
$searchContentClassAttributes = 0;
$searchContentClassAttributeArray = array();
if ( $http->hasVariable( 'SearchContentClassID' ) and
     $http->variable( 'SearchContentClassID' ) != -1 )
{
    $searchContentClassID = $http->variable( 'SearchContentClassID' );
    if ( (int) $searchContentClassID > 0 )
    {
        $searchContentClass = eZContentClass::fetch( (int) $searchContentClassID );
        if ( is_object( $searchContentClass ) )
            $searchContentClassAttributeArray = $searchContentClass->fetchSearchableAttributes();
    }
}

$searchContentClassAttributeID = -1;
if ( $http->hasVariable( 'SearchContentClassAttributeID' ) and
     $http->variable( 'SearchContentClassAttributeID' ) != -1 )
{
    $searchContentClassAttributeID = $http->variable( 'SearchContentClassAttributeID' );
}

$searchDate = -1;
if ( $http->hasVariable( 'SearchDate' ) and
     $http->variable( 'SearchDate' ) != -1 )
{
    $searchDate = $http->variable( 'SearchDate' );
}

$searchTimestamp = false;
if ( $http->hasVariable( 'SearchTimestamp' ) and
     $http->variable( 'SearchTimestamp' ) )
{
    $searchTimestamp = $http->variable( 'SearchTimestamp' );
}

$searchSectionID = -1;
if ( $http->hasVariable( 'SearchSectionID' ) and
     $http->variable( 'SearchSectionID' ) != -1 )
{
    $searchSectionID = $http->variable( 'SearchSectionID' );
}

$subTreeArray = array();
if ( $http->hasVariable( 'SubTreeArray' ) )
{
    if ( is_array( $http->variable( 'SubTreeArray' ) ) )
    {
        $subTreeList = $http->variable( 'SubTreeArray' );
    }
    else
    {
        $subTreeList = array( $http->variable( 'SubTreeArray' ) );
    }
    foreach ( $subTreeList as $subTreeItem )
    {
        // as form input is generally a string, is_int cannot be used for checking the value type
        if ( is_numeric( $subTreeItem ) && $subTreeItem > 0  )
        {
            $subTreeArray[] = $subTreeItem;
        }
    }
}

$Module->setTitle( "Search for: $searchText" );

$classArray = eZContentClass::fetchList();

$sectionArray = eZSection::fetchList();

$searchArray = eZSearch::buildSearchArray();

if ( $useSearchCode )
{
    $searchResult = eZSearch::search( $searchText, array( 'SearchSectionID' => $searchSectionID,
                                                          'SearchContentClassID' => $searchContentClassID,
                                                          'SearchContentClassAttributeID' => $searchContentClassAttributeID,
                                                          'SearchSubTreeArray' => $subTreeArray,
                                                          'SearchDate' => $searchDate,
                                                          'SearchTimestamp' => $searchTimestamp,
                                                          'SearchLimit' => $pageLimit,
                                                          'SearchOffset' => $Offset ),
                                       $searchArray );
    if ( strlen(trim($searchText)) == 0 && count( $searchArray ) > 0  )
    {
        $searchText = 'search by additional parameter';
    }
}

$viewParameters = array( 'offset' => $Offset );

$searchData = false;
$tpl->setVariable( "search_data", $searchData );
$tpl->setVariable( 'search_contentclass_id', $searchContentClassID );
$tpl->setVariable( 'search_contentclass_attribute_id', $searchContentClassAttributeID );
$tpl->setVariable( 'search_section_id', $searchSectionID );
$tpl->setVariable( 'search_date', $searchDate );
$tpl->setVariable( 'search_timestamp', $searchTimestamp );
$tpl->setVariable( 'search_sub_tree', $subTreeArray );
$tpl->setVariable( 'search_text', $searchText );
$tpl->setVariable( 'search_page_limit', $searchPageLimit );
$tpl->setVariable( 'full_search_text', $fullSearchText );
$tpl->setVariable( 'phrase_search_text', $phraseSearchText );

$tpl->setVariable( "view_parameters", $viewParameters );
$tpl->setVariable( 'use_template_search', !$useSearchCode );

// --- Compatibility code start ---
if ( $useSearchCode )
{
    $tpl->setVariable( 'offset', $Offset );
    $tpl->setVariable( 'page_limit', $pageLimit );
    $tpl->setVariable( 'search_text_enc', urlencode( $originalSearchText ) );
    $tpl->setVariable( 'phrase_search_text_enc', urlencode( $phraseSearchText ) );
    $tpl->setVariable( 'search_result', $searchResult['SearchResult'] );
    $tpl->setVariable( 'search_count', $searchResult['SearchCount'] );
    $tpl->setVariable( 'stop_word_array', $searchResult['StopWordArray'] );
    if ( isset( $searchResult["SearchExtras"] ) )
    {
        $tpl->setVariable( "search_extras", $searchResult["SearchExtras"] );
    }
}
else
{
    $tpl->setVariable( 'offset', false );
    $tpl->setVariable( 'page_limit', false );
    $tpl->setVariable( 'search_text_enc', false );
    $tpl->setVariable( 'phrase_search_text_enc', false );
    $tpl->setVariable( 'search_result', false );
    $tpl->setVariable( 'search_count', false );
    $tpl->setVariable( 'stop_word_array', false );
}
// --- Compatibility code end ---

$tpl->setVariable( 'content_class_array', $classArray );
$tpl->setVariable( 'section_array', $sectionArray );
$tpl->setVariable( 'search_content_class_attribute_array', $searchContentClassAttributeArray );

// Set template variable containing search terms for attribute-based search.
$searchTermsArray = array();
// BEGIN old code for backwards compatibility
// Set template variable for attribute-based search.
// Make it a hash with classattribute_id as key. If it has an identifier, add that to the key.
$searchArrayByClassAttributeID = array();
// END old code for backwards compatibility
foreach ( $searchArray as $searchItem )
{
    foreach ( $searchItem as $searchTerms )
    {
        if ( isSet( $searchTerms['identifier'] ) )
        {
            $searchTermsArray[$searchTerms['identifier']] = $searchTerms;
            // BEGIN old code for backwards compatibility
            $searchArrayByClassAttributeID[$searchTerms['classattribute_id'] . '_' .
                                           $searchTerms['identifier']] = $searchTerms;
            // END old code for backwards compatibility
        }
        else
        {
            $searchTermsArray[$searchTerms['classattribute_id']] = $searchTerms;
            // BEGIN old code for backwards compatibility
            $searchArrayByClassAttributeID[$searchTerms['classattribute_id']] = $searchTerms;
            // END old code for backwards compatibility
        }
    }
}
$tpl->setVariable( 'search_terms_array', $searchTermsArray );
// BEGIN old code for backwards compatibility
$tpl->setVariable( 'search_array_by_class_attribute_id', $searchArrayByClassAttributeID );
// END old code for backwards compatibility

if ( $searchSectionID != -1 )
{
    $section = eZSection::fetch( $searchSectionID );
    $res = eZTemplateDesignResource::instance();
    $keyArray = array( array( 'section', $searchSectionID ),
                       array( 'section_identifier', $section->attribute( 'identifier' ) ) );
    $res->setKeys( $keyArray );
}

$Result = array();

if ( trim( $ViewMode ) != '' )
{
    // Fetch override template for viewmode if wanted
    $Result['content'] = $tpl->fetch( "design:content/advancedsearch/$ViewMode.tpl" );
}
else
{
    $Result['content'] = $tpl->fetch( 'design:content/advancedsearch.tpl' );
}
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/content', 'Search' ),
                                'url' => false ),
                         array( 'text' => ezpI18n::tr( 'kernel/content', 'Advanced' ),
                                'url' => false ) );

$searchData = false;
if ( !$useSearchCode )
{
    if ( $tpl->hasVariable( "search_data" ) )
    {
        $searchData = $tpl->variable( "search_data" );
    }
}
else
{
    $searchData = $searchResult;
}

if ( $logSearchStats and
     trim( $searchText ) != "" and
     is_array( $searchData ) and
     array_key_exists( 'SearchCount', $searchData ) and
     is_numeric( $searchData['SearchCount'] ) )
{
    eZSearchLog::addPhrase( $searchText, $searchData["SearchCount"] );
}

?>
