<?php
/**
 * File containing the eZTopMenuOperator class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZTopMenuOperator eztopmenuoperator.php
  \brief The class eZTopMenuOperator does

*/


class eZTopMenuOperator
{
    /*!
     Constructor
    */
    function eZTopMenuOperator( $name = 'topmenu' )
    {
        $this->Operators = array( $name );
        $this->DefaultNames = array(
            'content' => array( 'name' => ezpI18n::tr( 'design/admin/pagelayout',
                                                  'Content structure' ),
                                'tooltip'=> ezpI18n::tr( 'design/admin/pagelayout',
                                                    'Manage the main content structure of the site.' ) ),
            'media' => array( 'name' => ezpI18n::tr( 'design/admin/pagelayout',
                                                'Media library' ),
                              'tooltip'=> ezpI18n::tr( 'design/admin/pagelayout',
                                                  'Manage images, files, documents, etc.' ) ),
            'users' => array( 'name' => ezpI18n::tr( 'design/admin/pagelayout',
                                                'User accounts' ),
                              'tooltip'=> ezpI18n::tr( 'design/admin/pagelayout',
                                                  'Manage users, user groups and permission settings.' ) ),
            'shop' => array( 'name' => ezpI18n::tr( 'design/admin/pagelayout',
                                               'Webshop' ),
                             'tooltip'=> ezpI18n::tr( 'design/admin/pagelayout',
                                                 'Manage customers, orders, discounts and VAT types; view sales statistics.' ) ),
            'design' => array( 'name' => ezpI18n::tr( 'design/admin/pagelayout',
                                                 'Design' ),
                               'tooltip'=> ezpI18n::tr( 'design/admin/pagelayout',
                                                   'Manage templates, menus, toolbars and other things related to appearence.' ) ),
            'setup' => array( 'name' => ezpI18n::tr( 'design/admin/pagelayout',
                                                'Setup' ),
                              'tooltip'=> ezpI18n::tr( 'design/admin/pagelayout',
                                                  'Configure settings and manage advanced functionality.' ) ),
            'dashboard' => array( 'name' => ezpI18n::tr( 'design/admin/pagelayout',
                                                     'Dashboard' ),
                                   'tooltip'=> ezpI18n::tr( 'design/admin/pagelayout',
                                                       'Manage items and settings that belong to your account.' ) ) );
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
        return array( 'context' => array( 'type' => 'string',
                                          'required' => true,
                                          'default' => 'content' ),
                      'filter_on_access' => array( 'type' => 'bool',
                                          'required' => false,
                                          'default' => false ) );
    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters, $placement )
    {

        $ini = eZINI::instance( 'menu.ini' );

        if ( !$ini->hasVariable( 'TopAdminMenu', 'Tabs' ) )
        {
            eZDebug::writeError( 'Top Admin menu is not configured. Ini  setting [TopAdminMenu] Tabs[] is missing' );
            $operatorValue = array();
            return;
        }

        $menu = array();
        $context = $namedParameters['context'];
        $tabIDs = $ini->variable( 'TopAdminMenu', 'Tabs' );
        foreach ( $tabIDs as $tabID )
        {
            $shownList = $ini->variable( 'Topmenu_' . $tabID , 'Shown' );
            if ( isset( $shownList[$context] ) && $shownList[$context] === 'false' )
            {
                continue;
            }

            $menuItem = array();
            $menuItem['access'] = true;
            if ( $ini->hasVariable( 'Topmenu_' . $tabID , 'PolicyList' ) )
            {
                $policyList = $ini->variable( 'Topmenu_' . $tabID , 'PolicyList' );
                foreach( $policyList as $policy )
                {
                    // Value is either "<node_id>" or "<module>/<function>"
                    if ( strpos( $policy, '/' ) !== false )
                    {
                        if ( !isset( $user ) )
                            $user = eZUser::currentUser();

                        list( $module, $function ) = explode( '/', $policy );
                        $result = $user->hasAccessTo( $module, $function );

                        if ( $result['accessWord'] === 'no' )
                        {
                            $menuItem['access'] = false;
                            break;
                        }
                    }
                    else
                    {
                        $node = eZContentObjectTreeNode::fetch( $policy );
                        if ( !$node instanceof eZContentObjectTreeNode || !$node->attribute('can_read') )
                        {
                            $menuItem['access'] = false;
                            break;
                        }
                    }
                }
            }

            if ( $namedParameters['filter_on_access'] && !$menuItem['access'] )
            {
                continue;
            }

            $urlList = $ini->variable( 'Topmenu_' . $tabID , 'URL' );
            if ( isset( $urlList[$context] ) )
            {
                $menuItem['url'] = $urlList[$context];
            }
            else
            {
                $menuItem['url'] = $urlList['default'];
            }

            $enabledList = $ini->variable( 'Topmenu_' . $tabID , 'Enabled' );
            if ( isset( $enabledList[$context] ) )
            {
                if ( $enabledList[$context] == 'true' )
                    $menuItem['enabled'] = true;
                else
                    $menuItem['enabled'] = false;
            }
            else
            {
                if ( $enabledList['default'] == true )
                    $menuItem['enabled'] = true;
                else
                    $menuItem['enabled'] = false;
            }

            if ( $ini->hasVariable( 'Topmenu_' . $tabID , 'Name' ) &&  $ini->variable( 'Topmenu_' . $tabID , 'Name' ) != '' )
            {
                $menuItem['name'] = $ini->variable( 'Topmenu_' . $tabID , 'Name' );
            }
            else
            {
                $menuItem['name'] = $this->DefaultNames[$tabID]['name'];
            }

            if ( $ini->hasVariable( 'Topmenu_' . $tabID , 'Tooltip' ) &&  $ini->variable( 'Topmenu_' . $tabID , 'Tooltip' ) != '' )
            {
                $menuItem['tooltip'] =  $ini->variable( 'Topmenu_' . $tabID , 'Tooltip' );
            }
            else
            {
                $menuItem['tooltip'] = isset( $this->DefaultNames[$tabID]['tooltip'] ) ? $this->DefaultNames[$tabID]['tooltip'] : '';
            }

            $menuItem['navigationpart_identifier'] =  $ini->variable( 'Topmenu_' . $tabID , 'NavigationPartIdentifier' );
            $menuItem['position'] = 'middle';
            $menu[] = $menuItem;

        }
        $menu[0]['position'] = 'first';
        $menu[count($menu) - 1]['position'] = 'last';

        $operatorValue = $menu;
    }

    /// \privatesection
    public $Operators;
    public $DefaultNames;
}


?>
