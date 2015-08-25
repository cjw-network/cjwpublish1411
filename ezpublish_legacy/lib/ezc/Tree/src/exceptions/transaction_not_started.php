<?php
/**
 * File containing the ezcTreeTransactionNotStartedException class.
 *
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * Exception that is thrown when "commit()" or "rollback()" are called without
 * a matching "beginTransaction()" call.
 *
 * @package Tree
 * @version //autogentag//
 */
class ezcTreeTransactionNotStartedException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeTransactionNotStartedException.
     */
    public function __construct()
    {
        parent::__construct( "A transaction is not active." );
    }
}
?>
