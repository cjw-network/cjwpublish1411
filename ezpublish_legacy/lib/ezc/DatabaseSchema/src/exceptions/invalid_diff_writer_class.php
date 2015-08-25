<?php
/**
 * File containing the ezcDbSchemaInvalidDiffWriterClassException class
 *
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception that is thrown if an invalid class is passed as schema writer to the manager.
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
class ezcDbSchemaInvalidDiffWriterClassException extends ezcDbSchemaException
{
    /**
     * Constructs an ezcDbSchemaInvalidDiffWriterClassException for writer class $writerClass
     *
     * @param string $writerClass
     */
    function __construct( $writerClass )
    {
        parent::__construct( "Class '{$writerClass}' does not exist, or does not implement the 'ezcDbSchemaDiffWriter' interface." );
    }
}
?>
