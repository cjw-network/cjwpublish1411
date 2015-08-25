<?php
/**
 * File containing the eZTreeMenuOperator class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

class eZTreeMenuOperator
{
    function eZTreeMenuOperator( $name = 'treemenu' )
    {
        $this->Operators = array( $name );
    }

    /*!
     Returns the operators in this class.
    */
    function operatorList()
    {
        return $this->Operators;
    }

    /*!
     See eZTemplateOperator::namedParameterList()
    */
    function namedParameterList()
    {
        return array( 'path' => array( 'type' => 'array',
                                       'required' => true,
                                       'default' => false ),
                      'node_id' => array( 'type' => 'int',
                                          'required' => false,
                                          'default' => false ),
                      'class_filter' => array( 'type' => 'array',
                                               'required' => false,
                                               'default' => false ),
                      'depth_skip' => array( 'type' => 'int',
                                             'required' => false,
                                             'default' => false ),
                      'max_level' => array( 'type' => 'int',
                                            'required' => false,
                                            'default' => false ),
                      'is_selected_method' => array( 'type' => 'string',
                                                     'required' => false,
                                                     'default' => 'tree' ),
                      'indentation_level' => array( 'type' => 'int',
                                                    'required' => false,
                                                    'default' => 15 ),
                      'language' => array( 'type' => 'string|array',
                                           'required' => false,
                                           'default' => false ),
                      'load_data_map' => array( 'type' => 'boolean',
                                           'required' => false,
                                           'default' => null ) );
    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters, $placement )
    {
        $level = 0;
        $done = false;
        $i = 0;
        $pathArray = array();
        $tmpModulePath = $namedParameters['path'];
        $classFilter = $namedParameters['class_filter'];
        $language = $namedParameters['language'];
        $loadDataMap = $namedParameters['load_data_map'];
        // node_id is not used anymore
        if ( !empty( $namedParameters['node_id'] ) )
        {
            eZDebug::writeNotice( 'Deprecated parameter "node_id" in treemenu template operator' );
        }

        if ( $classFilter === false )
        {
            $classFilter = array();
        }
        else if ( count( $classFilter ) == 0 )
        {
            $classFilter = array( 1 );
        }
        $classFilter = ( count( $classFilter ) == 1 and !isset( $classFilter[0] ) ) ? array( 1 ) : $classFilter;
        $tmpModulePathCount = count( $tmpModulePath );
        if ( !$tmpModulePath[ $tmpModulePathCount -1 ]['url'] and isset( $tmpModulePath[ $tmpModulePathCount -1 ]['node_id'] ) )
            $tmpModulePath[ $tmpModulePathCount -1 ]['url'] = '/content/view/full/' . $tmpModulePath[ $tmpModulePathCount -1 ]['node_id'];

        $depthSkip = $namedParameters['depth_skip'];
        $indentationLevel = $namedParameters['indentation_level'];

        $maxLevel = $namedParameters['max_level'];
        $isSelectedMethod = $namedParameters['is_selected_method'];
        if ( $maxLevel === false )
            $maxLevel = 2;

        while ( !$done && isset( $tmpModulePath[$i+$depthSkip] ) )
        {
            // get node id
            $elements = explode( '/', $tmpModulePath[$i+$depthSkip]['url'] );
            $nodeID = false;
            if ( isset( $elements[4] ) )
                $nodeID = $elements[4];

            $excludeNode = false;

            if ( isset( $elements[1] ) &&
                 isset( $elements[2] ) &&
                $elements[1] == 'content' &&
                $elements[2] == 'view' &&
                is_numeric( $nodeID ) &&
                $excludeNode == false &&
                $level < $maxLevel )
            {
                $node = eZContentObjectTreeNode::fetch( $nodeID );
                if ( !isset( $node ) ) { $operatorValue = $pathArray; return; }
                if ( isset( $tmpModulePath[$i+$depthSkip+1] ) )
                {
                    $nextElements = explode( '/', $tmpModulePath[$i+$depthSkip+1]['url'] );
                    if ( isset( $nextElements[4] ) )
                    {
                        $nextNodeID = $nextElements[4];
                    }
                    else
                    {
                        $nextNodeID = false;
                    }
                }
                else
                    $nextNodeID = false;

                $menuChildren = eZContentObjectTreeNode::subTreeByNodeID( array( 'Depth' => 1,
                                                                         'Offset' => 0,
                                                                         'SortBy' => $node->sortArray(),
                                                                         'Language' => $language,
                                                                         'ClassFilterType' => 'include',
                                                                         'ClassFilterArray' => $classFilter ),
                                                                  $nodeID );

                /// Fill objects with attributes, speed boost, only use if load_data_map is true
                // or if less then 16 nodes and param is not set (null)
                if ( $loadDataMap || (  $loadDataMap === null && count( $menuChildren ) <= 15 ) )
                    eZContentObject::fillNodeListAttributes( $menuChildren );

                $tmpPathArray = array();
                foreach ( $menuChildren as $child )
                {
                    $name = $child->attribute( 'name' );
                    $tmpNodeID = $child->attribute( 'node_id' );

                    $url = "/content/view/full/$tmpNodeID/";
                    $urlAlias = '/' . $child->attribute( 'url_alias' );
                    $hasChildren = $child->attribute( 'is_container' ) && $child->attribute( 'children_count' ) > 0;
                    $contentObject = $child->attribute( 'object' );

                    $indent = ($i - 1) * $indentationLevel;

                    $isSelected = false;
                    $nextNextElements = ( $isSelectedMethod == 'node' and isset( $tmpModulePath[$i+$depthSkip+2]['url'] ) ) ? explode( '/', $tmpModulePath[$i+$depthSkip+2]['url'] ) : null;
                    if ( $nextNodeID === $tmpNodeID and !isset( $nextNextElements[4] ) )
                    {
                        $isSelected = true;
                    }

                    $tmpPathArray[] = array( 'id' => $tmpNodeID,
                                             'level' => $i,
                                             'class_name' => $contentObject->classname(),
                                             'is_main_node' => $child->attribute( 'is_main' ),
                                             'has_children' => $hasChildren,
                                             'indent' => $indent,
                                             'url_alias' => $urlAlias,
                                             'url' => $url,
                                             'text' => $name,
                                             'is_selected' => $isSelected,
                                             'node' => $child );
                }

                // find insert pos
                $j = 0;
                $insertPos = 0;
                foreach ( $pathArray as $path )
                {
                    if ( $path['id'] == $nodeID )
                        $insertPos = $j;
                    $j++;
                }
                $restArray = array_splice( $pathArray, $insertPos + 1 );

                $pathArray = array_merge( $pathArray, $tmpPathArray );
                $pathArray = array_merge( $pathArray, $restArray );
            }
            else
            {
                if ( $level == 0 )
                {
                    $node = eZContentObjectTreeNode::fetch( 2 );
                    if ( !$node instanceof eZContentObjectTreeNode )
                    {
                        $operatorValue = $pathArray;
                        return;
                    }

                    $menuChildren = eZContentObjectTreeNode::subTreeByNodeID( array( 'Depth' => 1,
                                                                             'Offset' => 0,
                                                                             'SortBy' => $node->sortArray(),
                                                                             'Language' => $language,
                                                                             'ClassFilterType' => 'include',
                                                                             'ClassFilterArray' => $classFilter ),
                                                                      2 );

                    /// Fill objects with attributes, speed boost, only use if load_data_map is true
                    // or if less then 16 nodes and param is not set (null)
                    if ( $loadDataMap || (  $loadDataMap === null && count( $menuChildren ) < 16 ) )
                        eZContentObject::fillNodeListAttributes( $menuChildren );

                    $pathArray = array();
                    foreach ( $menuChildren as $child )
                    {
                        $name = $child->attribute( 'name' );
                        $tmpNodeID = $child->attribute( 'node_id' );

                        $url = "/content/view/full/$tmpNodeID/";
                        $urlAlias = '/' . $child->attribute( 'url_alias' );

                        $pathArray[] = array( 'id' => $tmpNodeID,
                                              'level' => $i,
                                              'is_main_node' => $child->attribute( 'is_main' ),
                                              'url_alias' => $urlAlias,
                                              'url' => $url,
                                              'text' => $name,
                                              'is_selected' => false,
                                              'node' => $child );
                    }
                }
                $done = true;
            }
            ++$level;
            ++$i;
        }

        $operatorValue = $pathArray;
    }

    /// \privatesection
    public $Operators;
}

?>
