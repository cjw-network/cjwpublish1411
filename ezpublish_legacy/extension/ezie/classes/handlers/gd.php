<?php
/**
 * File containing the eZIEEzcGDHandler class.
 *
 * @copyright Copyright (C) eZ Systems AS.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package ezie
 */
class eZIEEzcGDHandler extends ezcImageGdHandler implements eZIEEzcConversions
{
    /**
     * Apply the filter on the specified region and return the new resource
     *
     * @param  $filter
     * @param  $resource
     * @param  $region
     * @param  $colorspace
     * @param  $value parameters for region handling
     * @return imageresource
     */
    private function region( $filter, $resource, $region, $colorspace = null, $value = null )
    {
        $dest = imagecreatetruecolor( $region["w"], $region["h"] );
        if ( !imagecopy( $dest, $resource, 0, 0, $region["x"], $region["y"], $region["w"], $region["h"] ) )
        {
            throw new ezcImageFilterFailedException( "1/ {$function} applied on region {$region['x']}x{$region['y']}" );
        }

        if ( !$colorspace )
        {
            if ( $filter == "pixelateImg" )
            {
                $result = $this->$filter( $dest, imagesx( $resource ), imagesy( $resource ) );
            }
            else
                $result = $this->$filter( $dest, $value );
        }
        else
        {
            $this->setActiveResource( $dest );
            parent::colorspace( $colorspace );
            $result = $dest;
        }

        if ( !imagecopy( $resource, $result, $region["x"], $region["y"], 0, 0, $region["w"], $region["h"] ) )
        {
            throw new ezcImageFilterFailedException( "2/ {$function} applied on region {$region['x']}x{$region['y']}" );
        }

        return $resource;
    }

    /**
     *
     * @param  $hex
     * @return array
     */
    private function bgArrayFromHex( $hex )
    {
        return array(
            'r' => hexdec( substr( $hex, 0, 2 ) ),
            'g' => hexdec( substr( $hex, 2, 2 ) ),
            'b' => hexdec( substr( $hex, 4, 2 ) ),
            'a' => 127
        );
    }

    /* (non-PHPdoc)
     * @see lib/ezc/ImageConversion/src/handlers/ezcImageGdHandler#colorspace($space)
     */
    public function colorspace( $space, $region = null )
    {
        $resource = $this->getActiveResource();

        if ( $region )
        {
            $newResource = $this->region( null, $resource, $region, $space );
        }
        else
        {
            parent::colorspace( $space );
            return;
        }

        $this->setActiveResource( $newResource );
    }

    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#rotate($angle, $color)
     */
    public function rotate( $angle, $background = 'FFFFFF' )
    {
        $angle = intval( $angle );
        if ( !is_int( $angle ) || $angle < 0 || $angle > 360 )
        {
            throw new ezcBaseValueException( 'height', $angle, 'int > 0 && int < 360' );
        }

        $resource = $this->getActiveResource();

        $bg = $this->bgArrayFromHex( $background );
        $gdBackgroundColor = imagecolorallocatealpha( $resource, $bg['r'], $bg['g'], $bg['b'], $bg['a'] );

        $newResource = ImageRotate( $resource, $angle, $gdBackgroundColor );
        if ( $newResource === false )
        {
            throw new ezcImageFilterFailedException( 'rotate', 'Rotation of image failed.' );
        }

        imagedestroy( $resource );
        $this->setActiveResource( $newResource );
    }

    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#verticalFlip($region)
     */
    public function verticalFlip( $region = null )
    {
        $resource = $this->getActiveResource();

        $w = imagesx( $resource );
        $h = imagesy( $resource );

        $newResource = imagecreatetruecolor( $w, $h );

        imagealphablending( $newResource, false );
        imagesavealpha( $newResource, true );

        $res = imagecopyresampled( $newResource, $resource,
            0, 0,
            0, $h,
            $w, $h,
            $w, - $h );

        if ( $res === false )
        {
            throw new ezcImageFilterFailedException( 'rotate', 'Rotation of image failed.' );
        }

        imagedestroy( $resource );
        $this->setActiveResource( $newResource );
    }

    /**
     *
     * @param  $resource
     * @return unknown_type
     */
    private function horizontalFlipImg( $resource )
    {
        $w = imagesx( $resource );
        $h = imagesy( $resource );

        $newResource = imagecreatetruecolor( $w, $h );

        imagealphablending( $newResource, false );
        imagesavealpha( $newResource, true );

        $res = imagecopyresampled( $newResource, $resource,
            0, 0,
            $w, 0,
            $w, $h, - $w, $h );

        if ( $res === false )
        {
            throw new ezcImageFilterFailedException( 'rotate', 'Rotation of image failed.' );
        }

        imagedestroy( $resource );
        return $newResource;
    }

    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#horizontalFlip($region)
     */
    public function horizontalFlip( $region = null )
    {
        $resource = $this->getActiveResource();

        if ( $region )
        {
            $newResource = $this->region( "horizontalFlipImg", $resource, $region );
        }
        else
        {
            $newResource = $this->horizontalFlipImg( $resource );
        }

        $this->setActiveResource( $newResource );
    }

    /**
     *
     * @param  $resource
     * @param  $width
     * @param  $height
     * @return unknown_type
     */
    private function pixelateImg( $resource, $width, $height )
    {
        $w = imagesx( $resource );
        $h = imagesy( $resource );

        $size = ceil( max( $width, $height ) ) / 42;

        $tmp_w = $w / $size;
        $tmp_h = $h / $size;

        $tmpResource = imagecreatetruecolor( $tmp_w, $tmp_h );

        imagealphablending( $tmpResource, false );
        imagesavealpha( $tmpResource, true );

        $res = imagecopyresampled( $tmpResource, $resource,
            0, 0,
            0, 0,
            $tmp_w, $tmp_h,
            $w, $h );

        if ( $res === false )
        {
            throw new ezcImageFilterFailedException( 'pixelate', 'First part of pixelate failed.' );
        }
        imagedestroy( $resource );

        $newResource = imagecreatetruecolor( $w, $h );

        imagealphablending( $newResource, false );
        imagesavealpha( $newResource, true );

        $res = imagecopyresampled( $newResource, $tmpResource,
            0, 0,
            0, 0,
            $w, $h,
            $tmp_w, $tmp_h );

        if ( $res === false )
        {
            throw new ezcImageFilterFailedException( 'pixelate', 'Second part of pixelate failed.' );
        }

        imagedestroy( $tmpResource );
        return $newResource;
    }

    /**
     * contrast the given image, change $resource and return changed $resoure
     * @param $resource
     * @param $value contrast parameter
     * @return object $resource changed
     */
    private function contrastImg( $resource, $value )
    {
        imagefilter( $resource, IMG_FILTER_CONTRAST, - $value );
        return $resource;
    }
    
    /**
     * brightness the given image, change $resource and return changed $resource
     * @param $resource
     * @param unknown_type $value
     * @return object $resource changed
     */
    private function brightnessImg( $resource, $value )
    {
        imagefilter( $resource, IMG_FILTER_BRIGHTNESS, $value );
        return $resource;
    }
    
    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#pixelate($width, $height, $region)
     */
    public function pixelate( $width, $height, $region = null )
    {
        $resource = $this->getActiveResource();

        if ( $region )
        {
            $newResource = $this->region( "pixelateImg", $resource, $region );
        }
        else
        {
            $newResource = $this->pixelateImg( $resource, $width, $height );
        }

        $this->setActiveResource( $newResource );
    }

    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#brightness($value)
     */
    public function brightness( $value, $region = null )
    {
        $resource = $this->getActiveResource();

        if ( $value < - 255 || $value > 255 )
        {
            throw new ezcBaseValueException( 'value', $value, 'int >= -255 && int <= 255' );
        }
        
        if( $region )
        {
            $this->region( "brightnessImg", $resource, $region, null, $value );
        }
        else
        {
            $this->brightnessImg( $resource, $value );
        }
    }

    /* (non-PHPdoc)
     * @see extension/ezie/autoloads/eziezc/interfaces/eZIEEzcConversions#contrast($value)
     */
    public function contrast( $value, $region = null )
    {
        $resource = $this->getActiveResource();

        if ( $value < - 100 || $value > 100 )
        {
            throw new ezcBaseValueException( 'value', $value, 'int >= -100 && int <= 100' );
        }

        if ( $region )
        {
            $this->region( "contrastImg", $resource, $region, null, $value );
        }
        else
        {
            $this->contrastImg( $resource, $value );
        }
    }
}

?>
