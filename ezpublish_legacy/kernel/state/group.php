<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$Module = $Params['Module'];
$GroupIdentifier = $Params['GroupIdentifier'];
$LanguageCode = $Params['Language'];

$group = eZContentObjectStateGroup::fetchByIdentifier( $GroupIdentifier );

if ( !is_object( $group ) )
{
    return $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
}



$tpl = eZTemplate::factory();

$currentAction = $Module->currentAction();

if ( !$group->isInternal() )
{
    if ( $currentAction == 'Remove' && $Module->hasActionParameter( 'RemoveIDList' ) )
    {
        $removeIDList = $Module->actionParameter( 'RemoveIDList' );
        $group->removeStatesByID( $removeIDList );
    }
    else if ( $currentAction == 'Edit' )
    {
        return $Module->redirectTo( "state/group_edit/$GroupIdentifier" );
    }
    else if ( $currentAction == 'Create' )
    {
        return $Module->redirectTo( "state/edit/$GroupIdentifier" );
    }
    else if ( $currentAction == 'UpdateOrder' && $Module->hasActionParameter( 'Order' ) )
    {
        $orderArray = $Module->actionParameter( 'Order' );
        asort( $orderArray );
        $stateIDList = array_keys( $orderArray );

        $group->reorderStates( $stateIDList );
    }
}

if ( $LanguageCode )
{
    $group->setCurrentLanguage( $LanguageCode );
}

$tpl->setVariable( 'group', $group );

$Result = array(
    'path' => array(
        array( 'url' => false, 'text' => ezpI18n::tr( 'kernel/state', 'State' ) ),
        array( 'url' => 'state/groups', 'text' => ezpI18n::tr( 'kernel/state', 'Groups' ) ),
        array( 'url' => false, 'text' => $group->attribute( 'current_translation' )->attribute( 'name' ) )
    ),
    'content' => $tpl->fetch( 'design:state/group.tpl' )
)
?>
