<?php
/**
 * File containing the ezcTemplateFileFailedRenameException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception for problems when renaming template files.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateFileFailedRenameException extends ezcTemplateException
{

    /**
     * Initialises the exception with the original template file path and the new file path.
     *
     * @param string $from The original file path.
     * @param string $to The new file path.
     */
    public function __construct( $from, $to )
    {
        parent::__construct( "Renaming template file from '$from' to '$to' failed." );
    }
}
?>
