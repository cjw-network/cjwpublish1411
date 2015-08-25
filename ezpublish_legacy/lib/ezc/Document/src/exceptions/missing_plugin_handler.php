<?php
/**
 * Class containing the ezcDocumentWikiMissingPluginHandlerException class.
 *
 * @package Document
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown, when a wiki contains a plugin, for which no handler has
 * been registerd.
 *
 * @package Document
 * @version //autogentag//
 */
class ezcDocumentWikiMissingPluginHandlerException extends ezcDocumentException
{
    /**
     * Construct exception from directive name
     *
     * @param string $name
     */
    public function __construct( $name )
    {
        parent::__construct(
            "No plugin handler registered for plugin '{$name}'."
        );
    }
}

?>
