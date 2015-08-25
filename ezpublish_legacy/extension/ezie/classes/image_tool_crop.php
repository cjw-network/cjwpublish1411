<?php
/**
 * File containing the eZIEImageToolCrop class.
 * 
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package ezie
 */
class eZIEImageToolCrop extends eZIEImageAction
{
    /**
    * Creates a crop filter
    * 
    * @param  array(int) $region Affected region, as a 4 keys array: w, h, x, y
    * @return array( ezcImageFilter )
    */
    public static function filter( $region )
    {
        $r = array(
            'x'      => intval( $region['x'] ),
            'y'      => intval( $region['y'] ),
            'width'  => intval( $region['w'] ),
            'height' => intval( $region['h'] ) 
        );
        return array( new ezcImageFilter( 'crop', $r ) );
    }
}

?>
