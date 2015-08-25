<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$module = $Params['Module'];
$discountGroupID = null;
if ( isset( $Params["DiscountGroupID"] ) )
    $discountGroupID = $Params["DiscountGroupID"];

if ( is_numeric( $discountGroupID ) )
{
    $discountGroup = eZDiscountRule::fetch( $discountGroupID );
}
else
{
    $discountGroup = eZDiscountRule::create();
    $discountGroupID = $discountGroup->attribute( "id" );
}

$http = eZHTTPTool::instance();
if ( $http->hasPostVariable( "DiscardButton" ) )
{
    $module->redirectTo( $module->functionURI( "discountgroup" ) . "/" );
    return;
}
if ( $http->hasPostVariable( "ApplyButton" ) )
{
    if ( $http->hasPostVariable( "discount_group_name" ) )
    {
        $name = $http->postVariable( "discount_group_name" );
    }
    $discountGroup->setAttribute( "name", $name );
    $discountGroup->store();
    $module->redirectTo( $module->functionURI( "discountgroup" ) . "/" );
    return;
}

$module->setTitle( "Editing discount group" );
$tpl = eZTemplate::factory();
$tpl->setVariable( "module", $module );
$tpl->setVariable( "discount_group", $discountGroup );

$Result = array();
$Result['content'] = $tpl->fetch( "design:shop/discountgroupedit.tpl" );

?>
