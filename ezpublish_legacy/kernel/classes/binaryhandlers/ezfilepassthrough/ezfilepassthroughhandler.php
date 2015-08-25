<?php
/**
 * File containing the eZFilePassthroughHandler class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZFilePassthroughHandler ezfilepassthroughhandler.php
  \ingroup eZBinaryHandlers
  \brief Handles file downloading by passing the file through PHP

*/
class eZFilePassthroughHandler extends eZBinaryFileHandler
{
    const HANDLER_ID = 'ezfilepassthrough';

    function eZFilePassthroughHandler()
    {
        $this->eZBinaryFileHandler( self::HANDLER_ID, "PHP passthrough", eZBinaryFileHandler::HANDLE_DOWNLOAD );
    }

    function handleFileDownload( $contentObject, $contentObjectAttribute, $type,
                                 $fileInfo )
    {
        $fileName = $fileInfo['filepath'];

        $file = eZClusterFileHandler::instance( $fileName );

        if ( $fileName != "" and $file->exists() )
        {
            $fileSize = $file->size();
            if ( isset( $_SERVER['HTTP_RANGE'] ) && preg_match( "/^bytes=(\d+)-(\d+)?$/", trim( $_SERVER['HTTP_RANGE'] ), $matches ) )
            {
                $fileOffset = $matches[1];
                $contentLength = isset( $matches[2] ) ? $matches[2] - $matches[1] + 1 : $fileSize - $matches[1];
            }
            else
            {
                $fileOffset = 0;
                $contentLength = $fileSize;
            }
            // Figure out the time of last modification of the file right way to get the file mtime ... the
            $fileModificationTime = $file->mtime();

            // stop output buffering, and stop the session so that browsing can be continued while downloading
            eZSession::stop();
            ob_end_clean();

            eZFile::downloadHeaders(
                $fileName,
                self::dispositionType( $fileInfo['mime_type'] ) === 'attachment',
                false,
                $fileOffset,
                $contentLength,
                $fileSize
            );

            try
            {
                $file->passthrough( $fileOffset, $contentLength );
            }
            catch ( eZClusterFileHandlerNotFoundException $e )
            {
                eZDebug::writeError( $e->getMessage, __METHOD__ );
                header( $_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error' );
            }
            catch ( eZClusterFileHandlerGeneralException $e )
            {
                eZDebug::writeError( $e->getMessage, __METHOD__ );
                header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found' );
            }

            eZExecution::cleanExit();
        }
        return eZBinaryFileHandler::RESULT_UNAVAILABLE;
    }

    /**
     * Checks if a file should be downloaded to disk or displayed inline in
     * the browser.
     *
     * Behavior by MIME type and default behavior are configured in file.ini
     *
     * @param string $mimetype
     * @return string "attachment" or "inline"
     */
    protected static function dispositionType( $mimeType )
    {
        $ini = eZINI::instance( 'file.ini' );

        $mimeTypes = $ini->variable( 'PassThroughSettings', 'ContentDisposition', array() );
        if ( isset( $mimeTypes[$mimeType] ) )
        {
            return $mimeTypes[$mimeType];
        }

        return $ini->variable( 'PassThroughSettings', 'DefaultContentDisposition' );
    }
}

?>
