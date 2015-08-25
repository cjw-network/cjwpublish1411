<?php
/**
 * File containing the eZMath class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \defgroup eZMath eZ Math library
*/

/*!
  \class eZMath ezmath.php
  \brief eZMath provide a simple math library for common math operations
*/

class eZMath
{
    /*!
     Constructor
    */
    function eZMath()
    {
    }

    /*!
     \static

     Normalize RGB color array to 0..1 range

     \param array to normalize

     \return normalized array
    */
    static function normalizeColorArray( $array )
    {
        foreach ( array_keys( $array ) as $key )
        {
            $array[$key] = (float)$array[$key]/256;
        }

        return $array;
    }

    /*!
     \static

     Convert RGB to CMYK, Normalized values, between 0 and 1

     \param rgbArray RGB array
     \return CMYK array
    */
    static function rgbToCMYK( $rgbArray )
    {
        $cya = 1 - min( 1, max( (float)$rgbArray['r'], 0 ) );
        $mag = 1 - min( 1, max( (float)$rgbArray['g'], 0 ) );
        $yel = 1 - min( 1, max( (float)$rgbArray['b'], 0 ) );

        $min = min( $cya, $mag, $yel );
        if ( 1 - $min == 0 )
        {
            return array( 'c' => 1,
                          'm' => 1,
                          'y' => 1,
                          'k' => 0 );
        }

        return array( 'c' => ( $cya - $min ) / ( 1 - $min ),
                      'm' => ( $mag - $min ) / ( 1 - $min ),
                      'y' => ( $yel - $min ) / ( 1 - $min ),
                      'k' => $min );
    }

    /*!
     \static

     Convert rgb to CMYK

     \param r R
     \param g G
     \param b B

     \return CMYK return array
    */
    static function rgbToCMYK2( $r, $g, $b )
    {
        return eZMath::rgbToCMYK( array( 'r' => $r,
                                         'g' => $g,
                                         'b' => $b ) );
    }
}
?>
