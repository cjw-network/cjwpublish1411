<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$FunctionList = array();

$FunctionList['object'] = array( 'name' => 'object',
                                 'call_method' => array( 'class' => 'eZSectionFunctionCollection',
                                                         'method' => 'fetchSectionObject' ),
                                 'parameter_type' => 'standard',
                                 'parameters' => array( array( 'name' => 'section_id',
                                                               'type' => 'integer',
                                                               'required' => false,
                                                               'default' => false ),
                                                        array( 'name' => 'identifier',
                                                               'type' => 'string',
                                                               'required' => false,
                                                               'default' => false ) ) );

$FunctionList['list'] = array( 'name' => 'list',
                               'call_method' => array( 'class' => 'eZSectionFunctionCollection',
                                                       'method' => 'fetchSectionList' ),
                               'parameter_type' => 'standard',
                               'parameters' => array( ) );

$FunctionList['object_list'] = array( 'name' => 'object_list',
                                      'call_method' => array( 'class' => 'eZSectionFunctionCollection',
                                                              'method' => 'fetchObjectList' ),
                                      'parameter_type' => 'standard',
                                      'parameters' => array( array( 'name' => 'section_id',
                                                                    'type' => 'integer',
                                                                    'required' => true ),
                                                             array( 'name' => 'offset',
                                                                    'type' => 'integer',
                                                                    'required' => false,
                                                                    'default' => false ),
                                                             array( 'name' => 'limit',
                                                                    'type' => 'integer',
                                                                    'required' => false,
                                                                    'default' => false ),
                                                             array( 'name' => 'sort_order',
                                                                    'type' => 'variant',
                                                                    'required' => false,
                                                                    'default' => false ),
                                                             array( 'name' => 'status',
                                                                    'type' => 'string',
                                                                    'required' => false,
                                                                    'default' => false ) ) );

$FunctionList['object_list_count'] = array( 'name' => 'object_list_count',
                                            'call_method' => array( 'class' => 'eZSectionFunctionCollection',
                                                                    'method' => 'fetchObjectListCount' ),
                                            'parameter_type' => 'standard',
                                            'parameters' => array( array( 'name' => 'section_id',
                                                                          'type' => 'integer',
                                                                          'required' => true ),
                                                                   array( 'name' => 'status',
                                                                          'type' => 'string',
                                                                          'required' => false,
                                                                          'default' => false ) ) );

$FunctionList['roles'] = array( 'name' => 'roles',
                                'call_method' => array( 'class' => 'eZSectionFunctionCollection',
                                                        'method' => 'fetchRoles' ),
                                'parameter_type' => 'standard',
                                'parameters' => array( array( 'name' => 'section_id',
                                                              'type' => 'integer',
                                                              'required' => true ) ) );

$FunctionList['user_roles'] = array( 'name' => 'user_roles',
                                     'call_method' => array( 'class' => 'eZSectionFunctionCollection',
                                                             'method' => 'fetchUserRoles' ),
                                     'parameter_type' => 'standard',
                                     'parameters' => array( array( 'name' => 'section_id',
                                                                   'type' => 'integer',
                                                                   'required' => true ) ) );

?>
