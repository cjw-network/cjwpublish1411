<?php
/**
 * File containing the eZClusterHandlerDBNoDatabaseException class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/**
 * Class representing a no database exception
 *
 * @version 2014.11.1
 * @package kernel
 */

class eZClusterHandlerDBNoDatabaseException extends eZDBException
{
    /**
     * Constructs a new eZClusterHandlerDBNoDatabaseException
     *
     * @param string $dbname The database
     * @return void
     */
    function __construct( $dbname )
    {
        parent::__construct( "Unable to select the cluster database {$dbname}" );
    }
}
?>
