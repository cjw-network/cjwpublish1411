<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$FunctionList = array();
$FunctionList['list'] = array( 'name' => 'list',
                               'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                       'method' => 'fetchList' ),
                               'parameter_type' => 'standard',
                               'parameters' => array(  array( 'name' => 'filter_array',
                                                              'type' => 'array',
                                                              'required' => false,
                                                              'default' => false ),
                                                       array( 'name' => 'offset',
                                                              'type' => 'integer',
                                                              'default' => false,
                                                              'required' => false ),
                                                       array( 'name' => 'limit',
                                                              'type' => 'integer',
                                                              'default' => false,
                                                              'required' => false ),
                                                       array( 'name' => 'repository_id',
                                                              'type' => 'string',
                                                              'default' => false,
                                                              'required' => false ) ) );
$FunctionList['maintainer_role_list'] = array( 'name' => 'maintainer_role_list',
                                               'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                                       'method' => 'fetchMaintainerRoleList' ),
                                               'parameter_type' => 'standard',
                                               'parameters' => array(  array( 'name' => 'type',
                                                                              'type' => 'string',
                                                                              'required' => false,
                                                                              'default' => false ),
                                                                       array( 'name' => 'check_roles',
                                                                              'type' => 'boolean',
                                                                              'required' => false,
                                                                              'default' => false ) ) );
$FunctionList['can_create'] = array( 'name' => 'can_create',
                                     'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                             'method' => 'canCreate' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array() );

$FunctionList['can_edit'] = array( 'name' => 'can_edit',
                                   'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                           'method' => 'canEdit' ),
                                   'parameter_type' => 'standard',
                                   'parameters' => array() );

$FunctionList['can_import'] = array( 'name' => 'can_import',
                                     'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                             'method' => 'canImport' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array() );

$FunctionList['can_install'] = array( 'name' => 'can_install',
                                      'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                              'method' => 'canInstall' ),
                                      'parameter_type' => 'standard',
                                      'parameters' => array() );

$FunctionList['can_export'] = array( 'name' => 'can_export',
                                     'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                             'method' => 'canExport' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array() );

$FunctionList['can_read'] = array( 'name' => 'can_read',
                                   'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                           'method' => 'canRead' ),
                                   'parameter_type' => 'standard',
                                   'parameters' => array() );

$FunctionList['can_list'] = array( 'name' => 'can_list',
                                   'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                           'method' => 'canList' ),
                                   'parameter_type' => 'standard',
                                   'parameters' => array() );

$FunctionList['can_remove'] = array( 'name' => 'can_remove',
                                     'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                             'method' => 'canRemove' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array() );


$FunctionList['item'] = array( 'name' => 'item',
                               'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                       'method' => 'fetchPackage' ),
                               'parameter_type' => 'standard',
                               'parameters' => array( array( 'name' => 'package_name',
                                                             'type' => 'string',
                                                             'required' => true ),
                                                      array( 'name' => 'repository_id',
                                                             'type' => 'string',
                                                             'default' => false,
                                                             'required' => false ) ) );

$FunctionList['dependent_list'] = array( 'name' => 'dependent_list',
                                         'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                                 'method' => 'fetchDependentPackageList' ),
                                         'parameter_type' => 'standard',
                                         'parameters' => array( array( 'name' => 'package_name',
                                                                       'type' => 'string',
                                                                       'required' => true ),
                                                                array( 'name' => 'parameters',
                                                                       'type' => 'array',
                                                                       'required' => false,
                                                                       'default' => false ),
                                                                array( 'name' => 'repository_id',
                                                                       'type' => 'string',
                                                                       'default' => false,
                                                                       'required' => false ) ) );
$FunctionList['repository_list'] = array( 'name' => 'repository_list',
                                          'call_method' => array( 'class' => 'eZPackageFunctionCollection',
                                                                  'method' => 'fetchRepositoryList' ),
                                          'parameter_type' => 'standard',
                                          'parameters' => array() );
?>
