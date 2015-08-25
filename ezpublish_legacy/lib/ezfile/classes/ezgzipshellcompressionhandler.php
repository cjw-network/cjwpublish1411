<?php
/**
 * File containing the eZGZIPShellCompressionHandler class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package lib
 */

/*!
  \class eZGZIPShellCompressionHandler ezgzipshellcompressionhandler.php
  \brief Handles files compressed with gzip using the shell commands

  Handles GZIP compression by executing the 'gzip' executable,
  without this the handler cannot work.

NOTE: This is not done yet.
*/

class eZGZIPShellCompressionHandler extends eZCompressionHandler
{
    function eZGZIPShellCompressionHandler()
    {
        $this->File = false;
        $thus->Level = false;
        $this->eZCompressionHandler( 'GZIP (shell)', 'gzipshell' );
    }

    /*!
     Sets the current compression level.
    */
    function setCompressionLevel( $level )
    {
        if ( $level < 0 or $level > 9 )
            $level = false;
        $this->Level = $level;
    }

    /*!
     \return the current compression level which is a number between 0 and 9,
             or \c false if the default is to be used.
    */
    function compressionLevel()
    {
        return $this->Level;
    }

    /*!
     \return true if this handler can be used.
    */
    static function isAvailable()
    {
        return false;
    }

    function gunzipFile( $filename )
    {
        $command = 'gzip -dc $filename > $';
    }

    function doOpen( $filename, $mode )
    {
        $this->File = @gzopen( $filename, $mode );
    }

    function doClose()
    {
        return @gzclose( $this->File );
    }

    function doRead( $uncompressedLength = false )
    {
        return @gzread( $this->File, $uncompressedLength );
    }

    function doWrite( $data, $uncompressedLength = false )
    {
        return @gzwrite( $this->File, $uncompressedLength );
    }

    function doFlush()
    {
        return @fflush( $this->File );
    }

    function doSeek( $offset, $whence )
    {
        if ( $whence == SEEK_SET )
            $offset = $offset - gztell( $this->File );
        else if ( $whence == SEEK_END )
        {
            eZDebugSetting::writeError( 'lib-ezfile-gziplibz',
                                        "Seeking from end is not supported for gzipped files" );
            return false;
        }
        return @gzseek( $this->File, $offset );
    }

    function doRewind()
    {
        return @gzrewind( $this->File );
    }

    function doTell()
    {
        return @gztell( $this->File );
    }

    function doEOF()
    {
        return @gzeof( $this->File );
    }

    function doPasstrough( $closeFile = true )
    {
        return @gzpassthru( $this->File );
    }

    function compress( $source )
    {
        return @gzcompress( $source, $this->Level );
    }

    function decompress( $source )
    {
        return @gzuncompress( $source );
    }

    function errorString()
    {
        return false;
    }

    function errorNumber()
    {
        return false;
    }

    /// \privatesection
    /// File pointer, returned by gzopen
    public $File;
    /// The compression level
    public $Level;
}

?>
