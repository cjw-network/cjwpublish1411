<?php
/**
* File containing the eZIEImageToolFlipVer class.
* 
* @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
* @license http://ez.no/licenses/gnu_gpl GNU GPL v2
* @version 2014.11.1
* @package ezie
*/
class eZIEImageToolFlipVertically extends eZIEImageAction
{
    /**
    * Creates a vertical flip filter
    * 
    * @return array( ezcImageFilter )
    */
    static function filter()
    {
        return array(
            new ezcImageFilter( 
                'verticalFlip',
                array()
            )
        );
    }
}

?>