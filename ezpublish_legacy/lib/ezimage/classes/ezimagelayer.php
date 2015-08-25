<?php
/**
 * File containing the eZImageLayer class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZImageLayer ezimagelayer.php
  \ingroup eZImageObject
  \brief Defines a layer in a image object

*/

class eZImageLayer extends eZImageInterface
{
    /*!
     Constructor
    */
    function eZImageLayer( $imageObjectRef = null, $imageObject = null,
                           $width = false, $height = false, $font = false )
    {
        $this->eZImageInterface( $imageObjectRef, $imageObject, $width, $height );
        $this->setFont( $font );
        $this->TemplateURI = 'design:image/layer.tpl';
    }

    /*!
     A definition which tells the template engine which template to use
     for displaying the image.
    */
    function templateData()
    {
        return array( 'type' => 'template',
                      'template_variable_name' => 'layer',
                      'uri' => $this->TemplateURI );
    }

    /*!
     Sets the URI of the template to use for displaying it using the template engine to \a $uri.
    */
    function setTemplateURI( $uri )
    {
        $this->TemplateURI = $uri;
    }

    /*!
     Tries to merge the current layer with the layer \a $lastLayerData
     onto the image object \a $image.
     Different kinds of layer classes will merge layers differently.
    */
    function mergeLayer( $image, $layerData, $lastLayerData )
    {
        $position = $image->calculatePosition( $layerData['parameters'], $this->width(), $this->height() );
        $x = $position['x'];
        $y = $position['y'];
        $imageObject = $this->imageObject();
        if ( $lastLayerData === null )
        {
            $destinationImageObject = $image->imageObjectInternal( false );
            if ( $destinationImageObject === null )
            {
                $isTrueColor = $this->isTruecolor();
                $image->cloneImage( $this->imageObject(), $this->width(), $this->height(),
                                    $isTrueColor );
            }
            else
            {
                $image->mergeImage( $destinationImageObject, $imageObject,
                                    $x, $y,
                                    $this->width(), $this->height(), 0, 0,
                                    $image->getTransparencyPercent( $layerData['parameters'] ) );
            }
        }
        else
        {
            $destinationImageObject = $image->imageObjectInternal();
            $image->mergeImage( $destinationImageObject, $imageObject,
                                $x, $y,
                                $this->width(), $this->height(), 0, 0,
                                $image->getTransparencyPercent( $layerData['parameters'] ) );
        }
    }

    /*!
     Creates a new file layer for the file \a $fileName in path \a $filePath.
    */
    static function createForFile( $fileName, $filePath, $fileType = false )
    {
        $layer = new eZImageLayer();
        $layer->setStoredFile( $fileName, $filePath, $fileType );
        $layer->process();
        return $layer;
    }

    /// \privatesection
    public $TemplateURI;
}

?>
