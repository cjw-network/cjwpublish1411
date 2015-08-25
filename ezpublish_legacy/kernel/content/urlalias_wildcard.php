<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$Module =& $Params['Module'];
$http = eZHTTPTool::instance();

$Offset = $Params['Offset'];
if ( $Module->hasActionParameter( 'Offset' ) )
{
    $Offset = $Module->actionParameter( 'Offset' );
}

$tpl = eZTemplate::factory();
$limit = 20;

$infoCode = 'no-errors'; // This will be modified if info/warning is given to user.
$infoData = array(); // Extra parameters can be added to this array
$wildcardSrcText = false;
$wildcardDstText = false;
$wildcardType = false;

if ( $Module->isCurrentAction( 'RemoveAllWildcards' ) )
{
    eZURLWildcard::removeAll();

    eZURLWildcard::expireCache();

    $infoCode = "feedback-wildcard-removed-all";
}
else if ( $Module->isCurrentAction( 'RemoveWildcard' ) )
{
    if ( $http->hasPostVariable( 'WildcardIDList' ) )
    {
        $wildcardIDs = $http->postVariable( 'WildcardIDList' );

        eZURLWildcard::removeByIDs( $wildcardIDs );

        eZURLWildcard::expireCache();

        $infoCode = "feedback-wildcard-removed";
    }
}
else if ( $Module->isCurrentAction( 'NewWildcard' ) )
{
    $wildcardSrcText = trim( $Module->actionParameter( 'WildcardSourceText' ) );
    $wildcardDstText = trim( $Module->actionParameter( 'WildcardDestinationText' ) );
    $wildcardType = $http->hasPostVariable( 'WildcardType' ) && strlen( trim( $http->postVariable( 'WildcardType' ) ) ) > 0;

    if ( strlen( $wildcardSrcText ) == 0 )
    {
        $infoCode = "error-no-wildcard-text";
    }
    else if ( strlen( $wildcardDstText ) == 0 )
    {
        $infoCode = "error-no-wildcard-destination-text";
    }
    else
    {
        $wildcard = eZURLWildcard::fetchBySourceURL( $wildcardSrcText, false );
        if ( $wildcard )
        {
            $infoCode = "feedback-wildcard-exists";

            $infoData['wildcard_src_url'] = $wildcardSrcText;
            $infoData['wildcard_dst_url'] = $wildcard['destination_url'];
        }
        else
        {
            $row = array(
                'source_url' => $wildcardSrcText,
                'destination_url' => $wildcardDstText,
                'type' => $wildcardType ? eZURLWildcard::TYPE_FORWARD : eZURLWildcard::TYPE_DIRECT );

            $wildcard = new eZURLWildcard( $row );
            $wildcard->store();

            eZURLWildcard::expireCache();

            $infoData['wildcard_src_url'] = $wildcardSrcText;
            $infoData['wildcard_dst_url'] = $wildcardDstText;

            $wildcardSrcText = false;
            $wildcardDstText = false;
            $wildcardType = false;

            $infoCode = "feedback-wildcard-created";
        }
    }
}

// User preferences
$limitList = array( array( 'id'    => 1,
                           'value' => 10 ),
                    array( 'id'    => 2,
                           'value' => 25 ),
                    array( 'id'    => 3,
                           'value' => 50 ),
                    array( 'id'    => 4,
                           'value' => 100 ) );
$limitID = eZPreferences::value( 'admin_urlwildcard_list_limit' );
foreach ( $limitList as $limitEntry )
{
    $limitIDs[]                     = $limitEntry['id'];
    $limitValues[$limitEntry['id']] = $limitEntry['value'];
}
if ( !in_array( $limitID, $limitIDs ) )
{
    $limitID = 2;
}

// Fetch wildcads
$wildcardsLimit = $limitValues[$limitID];
$wildcardsCount = eZURLWildcard::fetchListCount();
// check offset, it can be out of range if some wildcards were removed.
if ( $Offset >= $wildcardsCount )
{
    $Offset = 0;
}
$wildcardList = eZURLWildcard::fetchList( $Offset, $wildcardsLimit );

$viewParameters = array( 'offset' => $Offset );


$path = array();
$path[] = array( 'url'  => false,
                 'text' => ezpI18n::tr( 'kernel/content/urlalias_wildcard', 'URL wildcard aliases' ) );

$tpl->setVariable( 'wildcard_list', $wildcardList );
$tpl->setVariable( 'wildcards_limit', $wildcardsLimit );
$tpl->setVariable( 'wildcards_count', $wildcardsCount );
$tpl->setVariable( 'info_code', $infoCode );
$tpl->setVariable( 'info_data', $infoData );
$tpl->setVariable( 'wildcardSourceText', $wildcardSrcText );
$tpl->setVariable( 'wildcardDestinationText', $wildcardDstText );
$tpl->setVariable( 'wildcardType', $wildcardType );
$tpl->setVariable( 'limitList', $limitList );
$tpl->setVariable( 'limitID', $limitID );
$tpl->setVariable( 'view_parameters', $viewParameters );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:content/urlalias_wildcard.tpl' );
$Result['path'] = $path;

?>
