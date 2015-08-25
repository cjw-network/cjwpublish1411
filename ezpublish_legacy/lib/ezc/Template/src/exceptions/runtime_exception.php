<?php
/**
 * File containing the ezcTemplateRuntimeException class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcTemplateRuntimeException is thrown when an error occurs while executing 
 * a template. For example when a {use} variable without a default value is 
 * not given.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateRuntimeException extends ezcTemplateException
{
    /**
     * Constructs a template runtime exception with message $msg.
     *
     * @param string $msg
     */
    public function __construct( $msg )
    {
        parent::__construct( $msg );
    }
}
?>
