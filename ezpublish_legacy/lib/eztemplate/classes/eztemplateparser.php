<?php
/**
 * File containing the eZTemplateParser class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZTemplateParser eztemplateparser.php
  \brief The class eZTemplateParser does

*/

class eZTemplateParser
{
    /*!
     Constructor
    */
    function eZTemplateParser()
    {
    }

    /*!
     Parses the template file $txt. The actual parsing implementation is done by inheriting classes.
    */
    function parse( $tpl, $sourceText, &$rootElement, $rootNamespace, &$relation )
    {
    }

}

?>
