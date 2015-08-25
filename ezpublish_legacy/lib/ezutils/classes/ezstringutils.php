<?php
/**
 * File containing the eZStringUtils class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZStringUtils ezstringutils.php
  \brief The class eZStringUtils does

*/

class eZStringUtils
{
    /*!
     Constructor
    */
    function eZStringUtils()
    {
    }

    static function  explodeStr( $str, $delimiter = '|' )
    {
        $offset = 0;
        $array = array();

        while( ( $pos = strpos( $str, $delimiter, $offset )  ) !== false )
        {
            $strPart = substr( $str, 0, $pos );
            if ( preg_match( '/(\\\\+)$/', $strPart, $matches ) )
            {
                if ( strlen( $matches[0] ) % 2 !== 0 )
                {
                    $offset = $pos+1;
                    continue;
                }
            }
            $array[] = str_replace( '\\\\', '\\', str_replace("\\$delimiter", $delimiter, $strPart ) );
            $str = substr( $str, $pos + 1 );
            $offset = 0;

        }
        $array[] = str_replace( '\\\\', '\\', str_replace("\\$delimiter", $delimiter, $str ) );
        return $array;
    }

    static function implodeStr( $values, $delimiter = '|' )
    {
        $str = '';
        while ( list( $key, $value ) = each( $values ) )
        {
            $values[$key] = str_replace( $delimiter, "\\$delimiter", str_replace( '\\', '\\\\', $value ) );
        }
        return implode( $delimiter, $values );
    }


}

?>
