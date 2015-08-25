<?php
/**
 * File containing the ConfigResolver class.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace Cjw\MultiSiteBundle\DependencyInjection\Configuration;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ConfigResolver;

use eZ\Publish\Core\MVC\Symfony\SiteAccess;
use eZ\Publish\Core\MVC\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CjwConfigResolver extends ConfigResolver
{

    /**
     * Returns value for $paramName, in $namespace.
     *
     * @param string $paramName The parameter name, without $prefix and the current scope (i.e. siteaccess name).
     * @param string $namespace Namespace for the parameter name. If null, the default namespace will be used.
     * @param string $scope The scope you need $paramName value for. It's typically the siteaccess name.
     *                      If null, the current siteaccess name will be used.
     *
     * @throws \eZ\Publish\Core\MVC\Exception\ParameterNotFoundException
     *
     * @return mixed
     */
    public function getParameter( $paramName, $namespace = null, $scope = null )
    {
        $value = parent::getParameter( $paramName, $namespace, $scope  );

        if ( $paramName == 'fieldtypes.ezxml.custom_xsl')
        {
            echo $paramName;
        }

        return $value;
    }

}
