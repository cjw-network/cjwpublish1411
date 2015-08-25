<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF;

/**
 * Request class
 *
 * The Request class can be used like a struct to access various information
 * which are associated with HTTP requests, like the method, query parameters
 * or the request body. For this handlers can be registered with the request
 * class, which process the requested information on-request (lazy). Each
 * handler returns the value, which is then provided again by the request
 * class on future requests to the same property.
 *
 * @version $Revision$
 *
 * @property string $body
 *           This property contains the raw request body.
 * @property array $variables
 *           This property contains all variables available in the current request.
 */
class Request
{
    /**
     * Array of handlers
     *
     * @var array
     */
    protected $handlers;

    /**
     * Contents extracted from the handlers
     *
     * @var array
     */
    protected $contents;

    /**
     * Construct request from a set of handlers
     *
     * @param array $handlers
     * @return void
     */
    public function __construct( array $handlers = array() )
    {
        foreach ( $handlers as $name => $handler )
        {
            $this->addHandler( $name, $handler );
        }
    }

    /**
     * Add a handler for a request property
     *
     * @param string $name
     * @param RequestPropertyHandler $handler
     * @return void
     */
    public function addHandler( $name, Request\PropertyHandler $handler )
    {
        $this->handlers[$name] = $handler;
    }

    /**
     * Get a request property
     *
     * @param string $property
     * @return mixed
     */
    public function __get( $property )
    {
        if ( isset( $this->contents[$property] ) )
        {
            return $this->contents[$property];
        }

        if ( isset( $this->handlers[$property] ) )
        {
            return $this->contents[$property] = $this->handlers[$property]->getValue();
        }

        throw new \InvalidArgumentException( "$property is not available in the request." );
    }

    /**
     * Allow to set arbitrary values in request struct
     *
     * @param string $property
     * @param mixed $value
     * @return void
     */
    public function __set( $property, $value )
    {
        $this->contents[$property] = $value;
    }

    /**
     * Returns if a value is set
     *
     * @param string $property
     * @return bool
     */
    public function __isset( $property )
    {
        return ( isset( $this->contents[$property] )
            || isset( $this->handlers[$property] ) );
    }
}

