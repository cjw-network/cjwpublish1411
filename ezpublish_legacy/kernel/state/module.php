<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$Module = array( 'name' => 'eZContentObjectState',
                 'variable_params' => false );

$ViewList = array();

$ViewList['assign'] = array(
    'default_navigation_part' => 'ezsetupnavigationpart',
    'script' => 'assign.php',
    'params' => array( 'ObjectID', 'SelectedStateID' ),
    'functions' => array( 'assign' ),
    'single_post_actions' => array( 'AssignButton' => 'Assign' ),
    'post_action_parameters' => array( 'Assign' => array( 'ObjectID'            => 'ObjectID',
                                                          'SelectedStateIDList' => 'SelectedStateIDList',
                                                          'RedirectRelativeURI' => 'RedirectRelativeURI' ) )
);

$ViewList['groups'] = array(
    'default_navigation_part' => 'ezsetupnavigationpart',
    'script' => 'groups.php',
    'params' => array(),
    'functions' => array( 'administrate' ),
    'unordered_params' => array( 'offset' => 'Offset' ),
    'single_post_actions' => array( 'CreateButton' => 'Create',
                                    'RemoveButton' => 'Remove' ),
    'post_action_parameters' => array( 'Remove' => array( 'RemoveIDList' => 'RemoveIDList' ) )
);

$ViewList['group'] = array(
    'default_navigation_part' => 'ezsetupnavigationpart',
    'script' => 'group.php',
    'params' => array( 'GroupIdentifier', 'Language' ),
    'functions' => array( 'administrate' ),
    'single_post_actions' => array( 'CreateButton' => 'Create',
                                    'UpdateOrderButton' => 'UpdateOrder',
                                    'EditButton' => 'Edit',
                                    'RemoveButton' => 'Remove' ),
    'post_action_parameters' => array( 'UpdateOrder' => array( 'Order' => 'Order' ),
                                       'Remove' => array( 'RemoveIDList' => 'RemoveIDList' ) )
);

$ViewList['group_edit'] = array(
    'default_navigation_part' => 'ezsetupnavigationpart',
    'script' => 'group_edit.php',
    'ui_context' => 'edit',
    'params' => array( 'GroupIdentifier' ),
    'functions' => array( 'administrate' ),
    'single_post_actions' => array( 'StoreButton' => 'Store',
                                    'CancelButton' => 'Cancel' )
);

$ViewList['view'] = array(
    'default_navigation_part' => 'ezsetupnavigationpart',
    'script' => 'view.php',
    'params' => array( 'GroupIdentifier', 'StateIdentifier', 'Language' ),
    'functions' => array( 'administrate' ),
    'single_post_actions' => array( 'EditButton' => 'Edit' )
);

$ViewList['edit'] = array(
    'default_navigation_part' => 'ezsetupnavigationpart',
    'script' => 'edit.php',
    'ui_context' => 'edit',
    'params' => array( 'GroupIdentifier', 'StateIdentifier' ),
    'functions' => array( 'administrate' ),
    'single_post_actions' => array( 'StoreButton' => 'Store',
                                    'CancelButton' => 'Cancel' )
);

$ClassID = array(
    'name'=> 'Class',
    'values'=> array(),
    'class' => 'eZContentClass',
    'function' => 'fetchList',
    'parameter' => array( 0, false, false, array( 'name' => 'asc' ) )
    );

$SectionID = array(
    'name'=> 'Section',
    'values'=> array(),
    'class' => 'eZSection',
    'function' => 'fetchList',
    'parameter' => array( false )
    );

$Assigned = array(
    'name'=> 'Owner',
    'values'=> array(
        array(
            'Name' => 'Self',
            'value' => '1')
        )
    );

$AssignedGroup = array(
    'name'=> 'Group',
    'single_select' => true,
    'values'=> array(
        array( 'Name' => 'Self',
               'value' => '1') ) );

$Node = array(
    'name'=> 'Node',
    'values'=> array()
    );

$Subtree = array(
    'name'=> 'Subtree',
    'values'=> array()
    );

$stateLimitations = eZContentObjectStateGroup::limitations();

$NewState = array(
    'name' => 'NewState',
    'values' => array(),
    'class' => 'eZContentObjectState',
    'function' => 'limitationList',
    'parameter' => array()
);

$FunctionList = array();

$FunctionList['administrate'] = array();

$FunctionList['assign'] = array( 'Class' => $ClassID,
                                 'Section' => $SectionID,
                                 'Owner' => $Assigned,
                                 'Group' => $AssignedGroup,
                                 'Node' => $Node,
                                 'Subtree' => $Subtree );

$FunctionList['assign'] = array_merge( $FunctionList['assign'], $stateLimitations, array( 'NewState' => $NewState ) );

?>
