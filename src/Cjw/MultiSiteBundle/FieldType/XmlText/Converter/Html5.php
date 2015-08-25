<?php
/**
 * File containing the Html5 class.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU General Public License v2.0
 * @version 
 */

namespace Cjw\MultiSiteBundle\FieldType\XmlText\Converter;

use eZ\Publish\Core\FieldType\XmlText\Converter\Html5 as BaseHtml5Converter;
use eZ\Publish\Core\MVC\ConfigResolverInterface;

/**
 * Adds ConfigResolver awareness to the original Html5 converter.
 *
 * Fixing a bug in eZ\Bundle\EzPublishCoreBundle\FieldType\XmlText\Converter\Html5
 * by overiding the class and fixing the rootDir of default value for 'fieldtypes.ezxml.custom_xsl'
 *
 * @see original ezclass eZ\Bundle\EzPublishCoreBundle\FieldType\XmlText\Converter\Html5
 */
class Html5 extends BaseHtml5Converter
{
    public function __construct( $stylesheet, ConfigResolverInterface $configResolver, array $preConverters = array() )
    {
        $customStylesheets = $configResolver->getParameter( 'fieldtypes.ezxml.custom_xsl' );

        // patch start
        for( $i = 0; $i < count( $customStylesheets); $i++ )
        {
            $customStylesheets[$i]['path'] = str_replace( 'app/../vendor', 'app/../../../../vendor', $customStylesheets[$i]['path'] );
        }
        // pathc ends

        $customStylesheets = $customStylesheets ?: array();
        parent::__construct( $stylesheet, $customStylesheets, $preConverters );
    }
}
