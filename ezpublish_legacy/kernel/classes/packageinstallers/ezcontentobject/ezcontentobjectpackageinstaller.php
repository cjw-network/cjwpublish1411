<?php
/**
 * File containing the eZContentObjectPackageInstaller class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \ingroup package
  \class eZContentObjectPackageInstaller ezcontentobjectpackageinstaller.php
  \brief A package creator for content objects
*/

class eZContentObjectPackageInstaller extends eZPackageInstallationHandler
{

    function eZContentObjectPackageInstaller( $package, $type, $installItem )
    {
        $steps = array();
        $steps[] = array( 'id' => 'site_access',
                          'name' => ezpI18n::tr( 'kernel/package', 'Site access mapping' ),
                          'methods' => array( 'initialize' => 'initializeSiteAccess',
                                              'validate' => 'validateSiteAccess' ),
                          'template' => 'site_access.tpl' );
        $steps[] = array( 'id' => 'top_nodes',
                          'name' => ezpI18n::tr( 'kernel/package', 'Top node placements' ),
                          'methods' => array( 'initialize' => 'initializeTopNodes',
                                              'validate' => 'validateTopNodes' ),
                          'template' => 'top_nodes.tpl' );
        $steps[] = array( 'id' => 'advanced_options',
                          'name' => ezpI18n::tr( 'kernel/package', 'Advanced options' ),
                          'methods' => array( 'initialize' => 'initializeAdvancedOptions',
                                              'validate' => 'validateAdvancedOptions' ),
                          'template' => 'advanced_options.tpl' );
        $this->eZPackageInstallationHandler( $package,
                                             $type,
                                             $installItem,
                                             ezpI18n::tr( 'kernel/package', 'Content object import' ),
                                             $steps );
    }

    /*!
     Returns \c 'stable', content class packages are always stable.
    */
    function packageInitialState( $package, &$persistentData )
    {
        return 'stable';
    }

    /*!
     \return \c 'contentobject'.
    */
    function packageType( $package, &$persistentData )
    {
        return 'contentobject';
    }

    function initializeSiteAccess( $package, $http, $step, &$persistentData, $tpl, $module )
    {
        $ini = eZINI::instance();
        $availableSiteAccessArray = $ini->variable( 'SiteAccessSettings', 'RelatedSiteAccessList' );

        if ( !isset( $persistentData['site_access_map'] ) )
        {
            $persistentData['site_access_map'] = array();
            $persistentData['site_access_available'] = $availableSiteAccessArray;
            $rootDOMNode = $this->rootDOMNode();
            $siteAccessListNode = $rootDOMNode->getElementsByTagName( 'site-access-list' )->item( 0 );

            foreach( $siteAccessListNode->getElementsByTagName( 'site-access' ) as $siteAccessNode )
            {
                $originalSiteAccessName = $siteAccessNode->textContent;
                if ( in_array( $originalSiteAccessName, $availableSiteAccessArray ) )
                {
                    $persistentData['site_access_map'][$originalSiteAccessName] = $originalSiteAccessName;
                }
                else
                {
                    $persistentData['site_access_map'][$originalSiteAccessName] = '';
                }
            }
        }

        $tpl->setVariable( 'site_access_map', $persistentData['site_access_map'] );
        $tpl->setVariable( 'available_site_access_array', $availableSiteAccessArray );
    }

    function validateSiteAccess( $package, $http, $currentStepID, &$stepMap, &$persistentData, &$errorList )
    {
        $validate = true;
        foreach( $persistentData['site_access_map'] as $originalSiteAccess => $newSiteAccess )
        {
            $persistentData['site_access_map'][$originalSiteAccess] = $http->postVariable( 'SiteAccessMap_'.$originalSiteAccess );
            if ( !in_array( $persistentData['site_access_map'][$originalSiteAccess], $persistentData['site_access_available'] ) )
            {
                $validate = false;
            }
        }

        return $validate;
    }

    function initializeTopNodes( $package, $http, $step, &$persistentData, $tpl, $module )
    {
        if ( !isset( $persistentData['top_nodes_map'] ) )
        {
            $persistentData['top_nodes_map'] = array();
            $rootDOMNode = $this->rootDOMNode();
            $topNodeListNode = $rootDOMNode->getElementsByTagName( 'top-node-list' )->item( 0 );

            $ini = eZINI::instance( 'content.ini' );
            $defaultPlacementNodeID = $ini->variable( 'NodeSettings', 'RootNode' );
            $defaultPlacementNode = eZContentObjectTreeNode::fetch( $defaultPlacementNodeID );
            $defaultPlacementName = $defaultPlacementNode->attribute( 'name' );
            foreach ( $topNodeListNode->getElementsByTagName( 'top-node' ) as $topNodeDOMNode )
            {
                $persistentData['top_nodes_map'][(string)$topNodeDOMNode->getAttribute( 'node-id' )] = array( 'old_node_id' => $topNodeDOMNode->getAttribute( 'node-id' ),
                                                                                                                'name' => $topNodeDOMNode->textContent,
                                                                                                                'new_node_id' => $defaultPlacementNodeID,
                                                                                                                'new_parent_name' => $defaultPlacementName );
            }
        }

        foreach( array_keys( $persistentData['top_nodes_map'] ) as $topNodeArrayKey )
        {
            if ( $http->hasPostVariable( 'BrowseNode_' . $topNodeArrayKey ) )
            {
                eZContentBrowse::browse( array( 'action_name' => 'SelectObjectRelationNode',
                                                'description_template' => 'design:package/installers/ezcontentobject/browse_topnode.tpl',
                                                'from_page' => '/package/install',
                                                'persistent_data' => array( 'PackageStep' => $http->postVariable( 'PackageStep' ),
                                                                            'InstallerType' => $http->postVariable( 'InstallerType' ),
                                                                            'InstallStepID' => $http->postVariable( 'InstallStepID' ),
                                                                            'ReturnBrowse_' . $topNodeArrayKey => 1 ) ),
                                         $module );
            }
            else if ( $http->hasPostVariable( 'ReturnBrowse_' . $topNodeArrayKey ) && !$http->hasPostVariable( 'BrowseCancelButton' ) )
            {
                $nodeIDArray = $http->postVariable( 'SelectedNodeIDArray' );
                if ( $nodeIDArray != null )
                {
                    $persistentData['top_nodes_map'][$topNodeArrayKey]['new_node_id'] = $nodeIDArray[0];
                    $contentNode = eZContentObjectTreeNode::fetch( $nodeIDArray[0] );
                    $persistentData['top_nodes_map'][$topNodeArrayKey]['new_parent_name'] = $contentNode->attribute( 'name' );
                }
            }
        }

        $tpl->setVariable( 'top_nodes_map', $persistentData['top_nodes_map'] );
    }

    function validateTopNodes( $package, $http, $currentStepID, &$stepMap, &$persistentData, &$errorList )
    {
        $validate = true;
        foreach( array_keys( $persistentData['top_nodes_map'] ) as $topNodeArrayKey )
        {
            if ( $persistentData['top_nodes_map'][$topNodeArrayKey]['new_node_id'] === false )
            {
                $errorList[] = array( 'field' => ezpI18n::tr( 'kernel/package', 'Select parent nodes' ),
                                      'description' => ezpI18n::tr( 'kernel/package', 'You must assign all nodes to new parent nodes.' ) );
                $validate = false;
                break;
            }
        }

        return $validate;
    }

    function initializeAdvancedOptions( $package, $http, $step, &$persistentData, $tpl, $module )
    {
        if ( !isset( $persistentData['use_dates_from_package'] ) )
        {
            $persistentData['use_dates_from_package'] = 0;
        }

        $tpl->setVariable( 'use_dates_from_package', (bool)$persistentData['use_dates_from_package'] );
    }

    function validateAdvancedOptions( $package, $http, $currentStepId, &$stepMap, &$persistentData, &$errorList )
    {
        $persistentData['use_dates_from_package'] = $http->postVariable( 'UseDatesFromPackage', 0 );
        return true;
    }

    function finalize( $package, $http, &$persistentData )
    {
        eZDebug::writeDebug( 'finalize is called', __METHOD__ );
        $package->installItem( $this->InstallItem, $persistentData );
    }

}
?>
