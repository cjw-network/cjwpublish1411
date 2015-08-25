<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$FunctionList = array();
$FunctionList['list'] = array( 'name' => 'list',
                               'operation_types' => array( 'read' ),
                               'call_method' => array( 'class' => 'eZClassFunctionCollection',
                                                       'method' => 'fetchClassList' ),
                               'parameter_type' => 'standard',
                               'parameters' => array( array( 'name' => 'class_filter',
                                                             'type' => 'array',
                                                             'required' => false,
                                                             'default' => false ),
                                                      array( 'name' => 'sort_by',
                                                             'type' => 'array',
                                                             'required' => false,
                                                             'default' => array() ) ) );

$FunctionList['list_by_groups'] = array( 'name' => 'list_by_groups',
                                        'operation_types' => array( 'read' ),
                                        'call_method' => array( 'class' => 'eZClassFunctionCollection',
                                                                'method' => 'fetchClassListByGroups' ),
                                        'parameter_type' => 'standard',
                                        'parameters' => array( array( 'name' => 'group_filter',
                                                                      'type' => 'array',
                                                                      'required' => true,
                                                                      'default' => false ),
                                                               array( 'name' => 'group_filter_type',
                                                                      'type' => 'string',
                                                                      'required' => false,
                                                                      'default' => 'include' ) ) );

$FunctionList['latest_list'] = array( 'operation_types' => array( 'read' ),
                                      'call_method' => array( 'class' => 'eZClassFunctionCollection',
                                                              'method' => 'fetchLatestClassList' ),
                                      'parameter_type' => 'standard',
                                      'parameters' => array( array( 'name' => 'offset',
                                                                    'type' => 'integer',
                                                                    'required' => false,
                                                                    'default' => false ),
                                                             array( 'name' => 'limit',
                                                                    'type' => 'integer',
                                                                    'required' => false,
                                                                    'default' => false ) ) );

$FunctionList['attribute_list'] = array( 'name' => 'attribute_list',
                                         'operation_types' => array( 'read' ),
                                         'call_method' => array( 'class' => 'eZClassFunctionCollection',
                                                                 'method' => 'fetchClassAttributeList' ),
                                         'parameter_type' => 'standard',
                                         'parameters' => array( array( 'name' => 'class_id',
                                                                       'type' => 'integer',
                                                                       'required' => true ) ) );



$FunctionList['override_template_list'] = array( 'name' => 'override_template_list',
                                                           'operation_types' => array( 'read' ),
                                                           'call_method' => array( 'class' => 'eZClassFunctionCollection',
                                                                                   'method' => 'fetchOverrideTemplateList' ),
                                                 'parameter_type' => 'standard',
                                                 'parameters' => array( array( 'name' => 'class_id',
                                                                               'type' => 'integer',
                                                                               'required' => true ) ) );

?>
