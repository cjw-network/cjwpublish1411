<?php

namespace Cjw\MultiSiteBundle\Matcher;

use eZ\Publish\Core\MVC\Symfony\SiteAccess\Matcher\Map\Host as BaseMapHost;


/**
 * Map/Host Matcher checking beginning of host name only, thus allowing generic host suffixes
 *
 * eg. www.example.com, www.example.com.ez53.df.lokal
 *
 * Use in ezpublish.yml as follows:
 *
 *     match:
 *         \Cjw\MultiSiteBundle\Matcher\MapHost:
 *                 www.example.com: example_user
 *                 admin.example.com: example_admin
 */
class MapHost extends BaseMapHost
{
    /**
     * Returns matching Siteaccess.
     *
     * @return string|false Siteaccess matched or false.
     */
    public function match()
    {
        foreach ( $this->map as $host => $siteAccess )
        {
            if ( strpos( $this->key, $host ) !== false )
            {
                // insert matched url to allow for reverse matching
                //$this->map[$this->key] = $siteAccess;
                return $siteAccess;
            }
        }
        return false;
    }

} 