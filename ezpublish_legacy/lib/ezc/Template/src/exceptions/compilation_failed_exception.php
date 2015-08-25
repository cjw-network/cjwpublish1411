<?php
/**
 * File containing the ezcTemplateCompilationFailedException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcTemplateCompilationFailedException is thrown when a template could
 * not be compiled.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateCompilationFailedException extends ezcTemplateException
{
    /**
     * Creates a exception for failed compilations, error message is
     * specified by caller.
     *
     * @param string $msg
     */
    public function __construct( $msg )
    {
        parent::__construct( $msg );
    }
}
?>
