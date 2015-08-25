<?php
/**
 * File containing the ezcSignalStaticConnectionsBase interface
 *
 * @package SignalSlot
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface for classes that implement a mail transport.
 *
 * Subclasses must implement the send() method.
 *
 * @package SignalSlot
 * @version //autogen//
 */
interface ezcSignalStaticConnectionsBase
{
    /**
     * Returns all the connections for signals $signal in signal collections
     * with the identifier $identifier.
     *
     * The format of the returned array is (priority=>array(phpCallbacks))
     *
     * The callback type is explained in the PHP manual (http://php.net/callback).
     *
     * The returned array MUST be sorted on priority.
     *
     * @param string $identifier
     * @param string $signal
     * @return array(int=>array(callback))
     */
    public function getConnections( $identifier, $signal );

}
?>
