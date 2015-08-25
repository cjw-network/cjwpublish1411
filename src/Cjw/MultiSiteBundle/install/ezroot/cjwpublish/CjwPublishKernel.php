<?php
/**
 * File containing the CjwPublishKernel class
 *
 * @copyright Copyright (C) 2007-2014 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @filesource
 *
 */

require_once __DIR__ . '/../src/Cjw/MultiSiteBundle/cjwpublish/CjwMultiSiteKernel.php';

class CjwPublishKernel extends CjwMultiSiteKernel
{

    /**
     * This method can be used to load additional bundles for all Kernels
     *
     * @return array|\Symfony\Component\HttpKernel\Bundle\Bundle[]
     */
    public function registerGlobalBundles()
    {
        $bundles = array();
        $bundles[] = new Cjw\MultiSiteBundle\CjwMultiSiteBundle();
        return $bundles;
    }

}
