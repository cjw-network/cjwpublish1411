<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request;
use Qafoo\RMF\Request;

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
 */
class HTTP extends Request
{
    /**
     * Construct request from a set of handlers
     *
     * @param array $handlers
     * @return void
     */
    public function __construct( array $handlers = array() )
    {
        $this->contents['path']        = $_SERVER['REQUEST_URI'];
        $this->contents['variables']   = $_GET;

        $this->addHandler( 'host', new Request\PropertyHandler\Server( 'HTTP_HOST' ) );
        $this->addHandler( 'method', new Request\PropertyHandler\Server( 'REQUEST_METHOD' ) );
        $this->addHandler( 'language', new Request\PropertyHandler\AcceptHeader( 'HTTP_ACCEPT_LANGUAGE', 'en' ) );
        $this->addHandler( 'encoding', new Request\PropertyHandler\AcceptHeader( 'HTTP_ACCEPT_CHARSET', 'utf-8' ) );
        $this->addHandler( 'compression', new Request\PropertyHandler\AcceptHeader( 'HTTP_ACCEPT_ENCODING', 'identity' ) );
        $this->addHandler( 'mimetype', new Request\PropertyHandler\AcceptHeader( 'HTTP_ACCEPT', '*/*' ) );

        parent::__construct( $handlers );
    }
}

