#!/usr/bin/env php
<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

require 'autoload.php';

$cli = eZCLI::instance();

$scriptSettings = array();
$scriptSettings['description'] = 'Update all attributes with datatype ezimage to use the new image system introduced in eZ Publish 3.3';
$scriptSettings['use-session'] = true;
$scriptSettings['use-modules'] = false;
$scriptSettings['use-extensions'] = true;

$script = eZScript::instance( $scriptSettings );
$script->startup();

$config = '';
$argumentConfig = '';
$optionHelp = false;
$arguments = false;
$useStandardOptions = true;

$options = $script->getOptions( $config, $argumentConfig, $optionHelp, $arguments, $useStandardOptions );
$script->initialize();

$script->setIterationData( '.', '~' );

$db = eZDB::instance();

$db->begin();

$imageManager = eZImageManager::factory();

$contentObjectAttributes = eZPersistentObject::fetchObjectList( eZContentObjectAttribute::definition(),
                                                                null,
                                                                array( 'data_type_string' => 'ezimage' ) );
$script->resetIteration( count( $contentObjectAttributes ) );

foreach ( $contentObjectAttributes as $contentObjectAttribute )
{
    $success = false;
    $xmlString = $contentObjectAttribute->attribute( 'data_text' );
    if ( $xmlString != '' )
    {
        $dom = new DOMDocument( '1.0', 'UTF-8' );
        $success = $dom->loadXML( $xmlString );
        unset( $dom );
    }

    if ( !$success )
    {
        // upgrade from old image system to the one introduced in eZ Publish 3.3
        $imageAliasHandler = new eZImageAliasHandler( $contentObjectAttribute );

        $attributeID = $contentObjectAttribute->attribute( 'id' );
        $attributeVersion = $contentObjectAttribute->attribute( 'version' );
        $objectID = $contentObjectAttribute->attribute( 'contentobject_id' );

        $imageRows = $db->arrayQuery( "SELECT * FROM ezimage
                                       WHERE contentobject_attribute_id=$attributeID AND
                                             version=$attributeVersion" );

        $doc = new DOMDocument( '1.0', 'utf-8' );
        $imageNode = $doc->createElement( 'ezimage' );
        $doc->appendChild( $imageNode );

        $isValid = false;
        $fileName = false;
        $suffix = false;
        $baseName = false;
        $dirPath = false;
        $filePath = false;
        $originalFileName = false;
        $mimeType = false;
        $width = false;
        $height = false;
        $altText = false;

        if ( count( $imageRows ) == 1 )
        {
            $fileHandler = eZClusterFileHandler::instance();

            $fileName         = $imageRows[0]['filename'];
            $originalFileName = $imageRows[0]['original_filename'];
            $mimeType         = $imageRows[0]['mime_type'];
            $altText          = $imageRows[0]['alternative_text'];

            $dirPath = eZSys::storageDirectory() . '/original/image';
            $filePath = $dirPath . '/' . $fileName;

            $baseName = $fileName;
            $dotPosition = strrpos( $fileName, '.' );
            if ( $dotPosition !== false )
            {
                $baseName = substr( $fileName, 0, $dotPosition );
                $suffix = substr( $fileName, $dotPosition + 1 );
            }

            $width = false;
            $height = false;
            $fileExists = file_exists( $filePath );
            if ( !$fileExists )
            {
                $referenceDirPath = eZSys::storageDirectory() . '/reference/image';
                $suffixList = array( 'jpg', 'png', 'gif' );
                foreach ( $suffixList as $suffix )
                {
                    $referenceFilePath = $referenceDirPath . '/' . $baseName . '.' . $suffix;
                    if ( file_exists( $referenceFilePath ) )
                    {
                        $filePath = $referenceFilePath;
                        $dirPath = $referenceDirPath;
                        $fileExists = true;
                        break;
                    }
                }
            }

            if ( $fileExists )
            {
                $isValid = true;
                $info = getimagesize( $filePath );
                if ( $info )
                {
                    $width = $info[0];
                    $height = $info[1];
                }
                $mimeInfo = eZMimeType::findByFileContents( $filePath );
                $mimeType = $mimeInfo['name'];

                $newFilePath = $filePath;
                $newSuffix = $suffix;
                $contentVersion = eZContentObjectVersion::fetchVersion( $attributeVersion,
                                                                        $objectID );
                if ( $contentVersion )
                {
                    $objectName = $imageAliasHandler->imageName( $contentObjectAttribute, $contentVersion );
                    $objectPathString = $imageAliasHandler->imagePath( $contentObjectAttribute, $contentVersion );

                    $newDirPath =  $objectPathString;
                    $newFileName = $objectName . '.' . $mimeInfo['suffix'];
                    $newSuffix = $mimeInfo['suffix'];
                    $newFilePath = $newDirPath . '/' . $newFileName;
                    $newBaseName = $objectName;
                }

                if ( $newFilePath != $filePath )
                {
                    if ( !file_exists( $newDirPath ) )
                    {
                        eZDir::mkdir( $newDirPath, false, true );
                    }
                    eZFileHandler::copy( $filePath, $newFilePath );

                    $filePath = $newFilePath;
                    $fileName = $newFileName;
                    $suffix = $newSuffix;
                    $dirPath = $newDirPath;
                    $baseName = $newBaseName;
                }
            }
        }

        $mimeData = eZMimeType::findByFileContents( $fileName );

        $imageManager->analyzeImage( $mimeData );

        $imageNode->setAttribute( 'serial_number', false );
        $imageNode->setAttribute( 'is_valid', $isValid );
        $imageNode->setAttribute( 'filename', $fileName );
        $imageNode->setAttribute( 'suffix', $suffix );
        $imageNode->setAttribute( 'basename', $baseName );
        $imageNode->setAttribute( 'dirpath', $dirPath );
        $imageNode->setAttribute( 'url', $filePath );
        $imageNode->setAttribute( 'original_filename', $originalFileName );
        $imageNode->setAttribute( 'mime_type', $mimeType );
        $imageNode->setAttribute( 'width', $width );
        $imageNode->setAttribute( 'height', $height );
        $imageNode->setAttribute( 'alternative_text', $altText );
        $imageNode->setAttribute( 'alias_key', $imageManager->createImageAliasKey( $imageManager->alias( 'original' ) ) );
        $imageNode->setAttribute( 'timestamp', time() );

        $imageAliasHandler->createImageInformationNode( $imageNode, $mimeData );

        $imageAliasHandler->storeDOMTree( $doc, true, false );

        eZImageFile::appendFilepath( $attributeID, $filePath );

        unset( $doc );

    }

    $script->iterate( $cli, !$success );
}

$db->commit();

// drop tables of old image system
$db->query( 'DROP TABLE ezimage' );
$db->query( 'DROP TABLE ezimagevariation' );

$script->shutdown( 0 );

?>
