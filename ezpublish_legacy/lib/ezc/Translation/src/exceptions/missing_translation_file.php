<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */

/**
 * Thrown when the translation file does not exist.
 *
 * @package Translation
 * @version //autogentag//
 */
class ezcTranslationMissingTranslationFileException extends ezcTranslationException
{
    /**
     * Constructs a new ezcTranslationMissingTranslationFileException.
     *
     * @param string $fileName
     * @return void
     */
    function __construct( $fileName )
    {
        parent::__construct( "The translation file '{$fileName}' does not exist." );
    }
}
?>
