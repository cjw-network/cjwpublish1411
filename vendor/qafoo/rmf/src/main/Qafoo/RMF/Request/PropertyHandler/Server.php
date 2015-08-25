<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request\PropertyHandler;
use Qafoo\RMF\Request\PropertyHandler;

/**
 * Property handler for common server variables
 *
 * @version $Revision$
 */
class Server extends PropertyHandler
{
    /**
     * Name of key in PHPs $_SERVER array.
     *
     * @var string
     */
    protected $key;

    /**
     * Construct from key in PHPs $_SERVER array
     *
     * @param string $key
     * @return void
     */
    public function __construct( $key )
    {
        $this->key = $key;
    }

    /**
     * Get value of property handler
     *
     * @return mixed
     */
    public function getValue()
    {
        if ( !isset( $_SERVER[$this->key] ) )
        {
            throw new \InvalidArgumentException( "{$this->key} is unknown in the SERVER array." );
        }

        return $_SERVER[$this->key];
    }
}

