<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$GroupIdentifier = $Params['GroupIdentifier'];
$Module = $Params['Module'];

$group = $GroupIdentifier === null ? new eZContentObjectStateGroup() : eZContentObjectStateGroup::fetchByIdentifier( $GroupIdentifier );

if ( !is_object( $group ) )
{
    return $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
}

if ( $group->isInternal() )
{
    return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );
}



$tpl = eZTemplate::factory();

$currentAction = $Module->currentAction();

if ( $currentAction == 'Cancel' )
{
    return $Module->redirectTo( 'state/groups' );
}
else if ( $currentAction == 'Store' )
{
    $group->fetchHTTPPersistentVariables();

    $messages = array();
    $isValid = $group->isValid( $messages );

    if ( $isValid )
    {
        $group->store();
        ezpEvent::getInstance()->notify( 'content/state/group/cache', array( $group->attribute( 'id' ) ) );
        if ( $GroupIdentifier === null )
        {
            return $Module->redirectTo( 'state/group/' . $group->attribute( 'identifier' ) );
        }
        else
        {
            return $Module->redirectTo( 'state/groups' );
        }
    }

    $tpl->setVariable( 'is_valid', $isValid );
    $tpl->setVariable( 'validation_messages', $messages );
}

$tpl->setVariable( 'group', $group );

if ( $GroupIdentifier === null )
{
    $path = array(
        array( 'url' => false, 'text' => ezpI18n::tr( 'kernel/state', 'State' ) ),
        array( 'url' => false, 'text' => ezpI18n::tr( 'kernel/state', 'New group' ) )
    );
}
else
{
    $path = array(
        array( 'url' => false, 'text' => ezpI18n::tr( 'kernel/state', 'State' ) ),
        array( 'url' => false, 'text' => ezpI18n::tr( 'kernel/state', 'Group edit' ) ),
        array( 'url' => false, 'text' => $group->attribute( 'identifier' ) )
    );
}

$Result = array(
    'content' => $tpl->fetch( 'design:state/group_edit.tpl' ),
    'path'    => $path
);

?>
