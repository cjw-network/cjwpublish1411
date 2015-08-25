<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$Module = array( 'name' => 'User management',
                 'variable_params' => true );

$ViewList = array();
$ViewList['logout'] = array(
    'functions' => array( 'login' ),
    'script' => 'logout.php',
    'ui_context' => 'authentication',
    'params' => array( ) );

$ViewList['login'] = array(
    'functions' => array( 'login' ),
    'script' => 'login.php',
    'ui_context' => 'authentication',
    'default_action' => array( array( 'name' => 'Login',
                                      'type' => 'post',
                                      'parameters' => array( 'Login',
                                                             'Password' ) ) ),
    'single_post_actions' => array( 'LoginButton' => 'Login' ),
    'post_action_parameters' => array( 'Login' => array( 'UserLogin' => 'Login',
                                                         'UserPassword' => 'Password',
                                                         'UserRedirectURI' => 'RedirectURI' ) ),
    'params' => array( ) );

$ViewList['setting'] = array(
    'functions' => array( 'preferences' ),
    'default_navigation_part' => 'ezusernavigationpart',
    'script' => 'setting.php',
    'params' => array( 'UserID' ) );

$ViewList['preferences'] = array(
    'functions' => array( 'login' ),
    'script' => 'preferences.php',
    'params' => array( 'Function', 'Key', 'Value' ) );

$ViewList['password'] = array(
    'functions' => array( 'password' ),
    'script' => 'password.php',
    'ui_context' => 'administration',
    'default_navigation_part' => 'ezmynavigationpart',
    'params' => array( 'UserID' ) );

$ViewList['forgotpassword'] = array(
    'functions' => array( 'password' ),
    'script' => 'forgotpassword.php',
    'params' => array( ),
    'ui_context' => 'administration',
    'single_post_actions' => array( 'GenerateButton' => 'Generate' ),
    'post_action_parameters' => array( 'Generate' => array( 'Login' => 'UserLogin',
                                                            'Email' => 'UserEmail' ) ),
    'params' => array( 'HashKey' ) );

/// \deprecated Use normal content edit view instead
$ViewList['edit'] = array(
    'functions' => array( 'login' ),
    'script' => 'edit.php',
    'ui_context' => 'edit',
    'single_post_actions' => array( 'ChangePasswordButton' => 'ChangePassword',
                                    'ChangeSettingButton' => 'ChangeSetting',
                                    'CancelButton' => 'Cancel',
                                    'EditButton' => 'Edit' ),
    'params' => array( 'UserID' ) );

$ViewList['register'] = array(
    'functions' => array( 'register' ),
    'script' => 'register.php',
    'params' => array( 'redirect_number' ),
    'ui_context' => 'edit',
    'default_navigation_part' => 'ezmynavigationpart',
    'single_post_actions' => array( 'PublishButton' => 'Publish',
                                    'CancelButton' => 'Cancel',
                                    'CustomActionButton' => 'CustomAction' ) );

$ViewList['activate'] = array(
    'functions' => array( 'login' ),
    'script' => 'activate.php',
    'ui_context' => 'authentication',
    'default_navigation_part' => 'ezmynavigationpart',
    'params' => array( 'Hash', 'MainNodeID' ) );

$ViewList['success'] = array(
    'functions' => array( 'register' ),
    'script' => 'success.php',
    'ui_context' => 'authentication',
    'default_navigation_part' => 'ezmynavigationpart',
    'params' => array( ) );

$ViewList['unactivated'] = array(
    'functions' => array( 'activation' ),
    'script' => 'unactivated.php',
    'ui_context' => 'administration',
    'default_navigation_part' => 'ezusernavigationpart',
    'unordered_params' => array( 'offset' => 'Offset' ),
    'single_post_actions' => array(
        'ActivateButton' => 'ActivateUsers',
        'RemoveButton' => 'RemoveUsers'
    ),
    'post_action_parameters' => array(
        'ActivateUsers' => array( 'UserIDs' => 'DeleteIDArray' ),
        'RemoveUsers' => array( 'UserIDs' => 'DeleteIDArray' ),
    ),
    'params' => array( 'SortField', 'SortOrder' ),
);

$SiteAccess = array(
    'name'=> 'SiteAccess',
    'values'=> array(),
    'class' => 'eZSiteAccess',
    'function' => 'siteAccessList',
    'parameter' => array()
    );

$FunctionList = array();
$FunctionList['login'] = array( 'SiteAccess' => $SiteAccess );
$FunctionList['password'] = array();
$FunctionList['preferences'] = array();
$FunctionList['register'] = array();
$FunctionList['selfedit'] = array();
$FunctionList['activation'] = array();

?>
