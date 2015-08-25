<?php
/**
 * File containing the eZStepFinal class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZStepFinal ezstep_final.php
  \brief The class eZStepFinal does

*/

class eZStepFinal extends eZStepInstaller
{
    /*!
     Constructor
    */
    function eZStepFinal( $tpl, $http, $ini, &$persistenceList )
    {
        $this->eZStepInstaller( $tpl, $http, $ini, $persistenceList,
                                'final', 'Final' );
    }

    function processPostData()
    {
        return true; // Last step, but always proceede
    }

    function init()
    {
        eZCache::clearByID( 'global_ini' );
        return false; // Always show
    }

    function display()
    {
        $siteType = $this->chosenSiteType();

        $siteaccessURLs = $this->siteaccessURLs();

        $siteType['url'] = $siteaccessURLs['url'];
        $siteType['admin_url'] = $siteaccessURLs['admin_url'];

        $customText = isset( $this->PersistenceList['final_text'] ) ? $this->PersistenceList['final_text'] : '';

        $this->Tpl->setVariable( 'site_type', $siteType );

        $this->Tpl->setVariable( 'custom_text', $customText );

        $this->Tpl->setVariable( 'setup_previous_step', 'Final' );
        $this->Tpl->setVariable( 'setup_next_step', 'Final' );

        $result = array();
        // Display template
        $result['content'] = $this->Tpl->fetch( 'design:setup/init/final.tpl' );
        $result['path'] = array( array( 'text' => ezpI18n::tr( 'design/standard/setup/init',
                                                          'Finished' ),
                                        'url' => false ) );
        return $result;

    }
}

?>
