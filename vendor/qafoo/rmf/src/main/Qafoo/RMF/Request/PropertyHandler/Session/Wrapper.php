<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request\PropertyHandler\Session;

/**
 * Wrapper around PHP sessions
 *
 * This class is used to have an object, which we can pass around and maintain
 * a reference to the original PHP $_SESSION array without hassle.
 *
 * Also prevents from notices when used as a virtual object property and we
 * write to its properties.
 *
 * @version $Revision$
 */
class Wrapper implements \ArrayAccess
{
    /**
     * Returns if a value exists.
     *
     * Allows isset() using ArrayAccess.
     *
     * @param string $key
     * @return bool
     */
    final public function offsetExists( $key )
    {
        return isset( $_SESSION[$key] );
    }

    /**
     * Returns a value.
     *
     * Get a value by ArrayAccess.
     *
     * @param string $key
     * @return mixed
     */
    final public function offsetGet( $key )
    {
        if ( isset( $_SESSION[$key] ) )
        {
            return $_SESSION[$key];
        }

        throw new \InvalidArgumentException( "No such key: " . $key );
    }

    /**
     * Set a value.
     *
     * Sets a value using ArrayAccess.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function offsetSet( $key, $value )
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Unset a value.
     *
     * Unsets a value using ArrayAccess.
     *
     * @param string $key
     * @return void
     */
    final public function offsetUnset( $key )
    {
        unset( $_SESSION[$key] );
    }
}

