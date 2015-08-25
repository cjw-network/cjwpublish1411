<?php
/**
 * File containing the eZBinaryFileHandler class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
 \defgroup eZBinaryHandlers Binary file handlers
*/

/*!
  \class eZBinaryFileHandler ezbinaryfilehandler.php
  \ingroup eZKernel
  \brief Interface for all binary file handlers

*/

class eZBinaryFileHandler
{
    const HANDLE_UPLOAD = 0x1;
    const HANDLE_DOWNLOAD = 0x2;

    const HANDLE_ALL = 0x3; // HANDLE_UPLOAD | HANDLE_DOWNLOAD

    const TYPE_FILE = 'file';
    const TYPE_MEDIA = 'media';

    const RESULT_OK = 1;
    const RESULT_UNAVAILABLE = 2;

    function eZBinaryFileHandler( $identifier, $name, $handleType )
    {
        $this->Info = array();
        $this->Info['identifier'] = $identifier;
        $this->Info['name'] = $name;
        $this->Info['handle-type'] = $handleType;
    }

    function attributes()
    {
        return array_keys( $this->Info );
    }

    function hasAttribute( $attribute )
    {
        return isset( $this->Info[$attribute] );
    }

    function attribute( $attribute )
    {
        if ( isset( $this->Info[$attribute] ) )
        {
            return $this->Info[$attribute];
        }

        eZDebug::writeError( "Attribute '$attribute' does not exist", __METHOD__ );
        return null;
    }

    /*!
     \return the suffix for the template name which will be used for attribute viewing.
     \note Default returns false which means no special template.
    */
    function viewTemplate( $contentobjectAttribute )
    {
        $retVal = false;
        return $retVal;
    }

    /*!
     \return the suffix for the template name which will be used for attribute viewing.
     \note Default returns false which means no special template.
    */
    function editTemplate( $contentobjectAttribute )
    {
        $retVal = false;
        return $retVal;
    }

    /*!
     \return the suffix for the template name which will be used for attribute viewing.
     \note Default returns false which means no special template.
    */
    function informationTemplate( $contentobjectAttribute )
    {
        $retVal = false;
        return $retVal;
    }

    function handleUpload()
    {
        return false;
    }

    /*!
     \return the file object which corresponds to \a $contentObject and \a $contentObjectAttribute.
    */
    function downloadFileObject( $contentObject, $contentObjectAttribute )
    {
        $contentObjectAttributeID = $contentObjectAttribute->attribute( 'id' );
        $version = $contentObject->attribute( 'current_version' );
        $fileObject = eZBinaryFile::fetch( $contentObjectAttributeID, $version );
        if ( $fileObject )
            return $fileObject;
        $fileObject = eZMedia::fetch( $contentObjectAttributeID, $version );
        return $fileObject;
    }

    function handleDownload( $contentObject, $contentObjectAttribute, $type )
    {
        $contentObjectAttributeID = $contentObjectAttribute->attribute( 'id' );
        $version = $contentObject->attribute( 'current_version' );



        if ( !$contentObjectAttribute->hasStoredFileInformation( $contentObject, $version,
                                                                 $contentObjectAttribute->attribute( 'language_code' ) ) )
            return self::RESULT_UNAVAILABLE;

        $fileInfo = $contentObjectAttribute->storedFileInformation( $contentObject, $version,
                                                                    $contentObjectAttribute->attribute( 'language_code' ) );
        if ( !$fileInfo )
            return self::RESULT_UNAVAILABLE;
        if ( !$fileInfo['mime_type'] )
            return self::RESULT_UNAVAILABLE;

        $contentObjectAttribute->handleDownload( $contentObject, $version,
                                                 $contentObjectAttribute->attribute( 'language_code' ) );

        return $this->handleFileDownload( $contentObject, $contentObjectAttribute, $type, $fileInfo );
    }

    function handleFileDownload( $contentObject, $contentObjectAttribute, $type, $mimeData )
    {
        return false;
    }

    function repositories()
    {
        return array( 'kernel/classes/binaryhandlers' );
    }

    /**
     * Returns a shared instance of the eZBinaryFileHandler class
     * pr $handlerName as defined in file.ini[BinaryFileSettings]Handler
     *
     * @param string|false $identifier Uses file.ini[BinaryFileSettings]Handler if false
     * @return eZBinaryFileHandler
     */
    static function instance( $identifier = false )
    {
        if ( $identifier === false )
        {
            $fileINI = eZINI::instance( 'file.ini' );
            $identifier = $fileINI->variable( 'BinaryFileSettings', 'Handler' );
        }
        $instance =& $GLOBALS['eZBinaryFileHandlerInstance-' . $identifier];
        if ( !isset( $instance ) )
        {
            $optionArray = array( 'iniFile'     => 'file.ini',
                                  'iniSection'  => 'BinaryFileSettings',
                                  'iniVariable' => 'Handler'  );

            $options = new ezpExtensionOptions( $optionArray );

            $instance = eZExtension::getHandlerClass( $options );

            if( $instance === false )
            {
                eZDebug::writeError( "Could not find binary file handler '$identifier'", __METHOD__ );
            }
        }
        return $instance;
    }

    /// \privatesection
    public $Info;
}

?>
