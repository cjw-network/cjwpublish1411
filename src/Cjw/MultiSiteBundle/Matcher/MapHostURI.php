<?php

namespace Cjw\MultiSiteBundle\Matcher;

use eZ\Publish\Core\MVC\Symfony\SiteAccess\Matcher\Map\URI as BaseMapURI;


/**
 * Map/HostURI Matcher
 *
 * which checks the host beginns with the yml item and the yml uri item
 * with the possibility to
 *
 * eg. www.example.com/de, www.example.com.ez53.fw.lokal/de
 *
 * Use in ezpublish.yml as follows:
 *
 *     match:
 *         \Cjw\MultiSiteBundle\Matcher\MapHostURI:
 *                 www.example.com/de/(default): example_user_de
 *                 www.example.com/en: example_user_en
 *                 www.example.net/de: example_net_user_de
 *                 www.example.net/en: example_net_user_en
 *
 *  /(default)  => if no uri element is set this value is using as default Siteaccess and setting the uri element to
 * the defined value
 * in our case  http://www.example.com will call defaultSiteaccess example_user_de and setting the uripart to 'de'
 * so all rendered ez urls will get an prefix 'de' so the next call is www.example.com/de/...
 *
 */
class MapHostURI extends BaseMapURI
{

    var $isDefaultSiteAccessMatch = false;

    public function getName()
    {
        return 'hosturi:map';
    }


    /**
     * Fixes up $uri to remove the siteaccess part, if needed.
     *
     * @param string $uri The original URI
     *
     * @return string
     */
    public function analyseURI( $uri )
    {
        if ( $this->isDefaultSiteAccessMatch )
            return $uri;
        else
            return substr( $uri, strlen( "/$this->key" ) );
    }

    /**
     * Returns matching Siteaccess.
     *
     * @return string|false Siteaccess matched or false.
     */
    public function match()
    {
        // www.test.de.cjw1411.fw.lokal
        $requestHost = $this->request->host;
        // de
        $requestUriPart = $this->key;

        // host        => array( uripart, siteaccess )
        // www.test.de => array( 'de', 'test_user_de' )
        $defaultMapUriArray = array();

        $defaultHostKey = '';

        foreach ( $this->map as $hostUri => $siteAccess )
        {
            // $hostUri =  www.test.de/de
            // $siteAccess = test_user_de
            $hostUriArray = explode( '/', $hostUri );

            // www.test.de
            $host = $hostUriArray[0];
            if ( isset( $hostUriArray[1] ) )
            {
               // de
               $uriPart = $hostUriArray[1];

               // storing defaultsettings for host and uri part for later use
               if ( isset( $hostUriArray[2] ) )
               {
                   // www.test.de => array( de, test_user_de )
                   $defaultMapUriArray[$host] = array( $uriPart, $siteAccess );
               }
            }

            // www.test.de.cjw1411.fw.lokal begins with www.test.de
            // und  de == de
            if ( strpos( $requestHost, $host ) !== false  )
            {
                $defaultHostKey = $host;
                if ( $requestUriPart == $uriPart )
                {
                    // insert matched url to allow for reverse matching
                    //$this->map[$this->key] = $siteAccess;
                    return $siteAccess;
                }
            }
        }

        // if a defaultsettings is found use it
        if ( isset( $defaultMapUriArray[$defaultHostKey] ) )
        {
            $uriPart = $defaultMapUriArray[$defaultHostKey][0];
            $defaultSiteAccess = $defaultMapUriArray[$defaultHostKey][1];

            // store uriPart for later => to remove from uri internaly
            $this->key = $uriPart;
            $this->isDefaultSiteAccessMatch = true;

            return $defaultSiteAccess;
        }

        return false;
    }


} 