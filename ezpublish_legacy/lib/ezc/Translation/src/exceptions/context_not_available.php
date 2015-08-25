<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */

/**
 * Thrown by the getContext() method when a requested context doesn't exist.
 *
 * @package Translation
 * @version //autogentag//
 */
class ezcTranslationContextNotAvailableException extends ezcTranslationException
{
    /**
     * Constructs a new ezcTranslationContextNotAvailableException.
     *
     * @param string $contextName
     * @return void
     */
    function __construct( $contextName )
    {
        parent::__construct( "The context '{$contextName}' does not exist." );
    }
}
?>
