<?php
/**
 * File containing the ezcAuthenticationTypekeyException class.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 * @package Authentication
 * @version //autogen//
 */

/**
 * Thrown when an exceptional state occurs in the TypeKey authentication.
 *
 * @package Authentication
 * @version //autogen//
 */
class ezcAuthenticationTypekeyException extends ezcAuthenticationException
{
    /**
     * Constructs a new ezcAuthenticationTypekeyException with error message
     * $message.
     *
     * @param string $message Message to throw
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>
