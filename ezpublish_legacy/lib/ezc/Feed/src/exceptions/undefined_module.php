<?php
/**
 * File containing the ezcFeedUndefinedModuleException class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Thrown when trying to get information from a module which is not defined yet.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedUndefinedModuleException extends ezcFeedException
{
    /**
     * Constructs a new ezcFeedUndefinedModuleException.
     *
     * @param string $module The name of the module
     */
    public function __construct( $module )
    {
        parent::__construct( "The module '{$module}' is not defined yet." );
    }
}
?>
