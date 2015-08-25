<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Router;
use Qafoo\RMF\Router;
use Qafoo\RMF\Request;

/**
 * Router base class
 *
 * The Router descides which controller should be called based on the
 * information, which can be found in the ``Request``.
 *
 * @version $Revision$
 */
class Regexp extends Router
{
    /**
     * Routes
     *
     * @var array
     */
    protected $routes;

    /**
     * Create router from a set of regexp based routes
     *
     * The array should be specified like:
     *
     * <code>
     *  array(
     *      '(regexp)' => array(
     *          '<method>' => <callback>,
     *          …
     *      ), …
     *  ),
     * </code>
     *
     * Where the regular expression should match the path and the method
     * specifies the HTTP method, which has been called
     *
     * @param array $routes
     * @return void
     */
    public function __construct( array $routes = array() )
    {
        foreach ( $routes as $regexp => $callbacks )
        {
            foreach ( $callbacks as $method => $callback )
            {
                $this->addRoute( $method, $regexp, $callback );
            }
        }
    }

    /**
     * Add a regexp based route
     *
     * The regular expression is amtched against the request path. If the
     * regular expression matches the callback will be returned.
     *
     * @param string $method
     * @param string $regexp
     * @param Callback $callback
     * @return void
     */
    public function addRoute( $method, $regexp, $callback )
    {
        $this->routes[strtoupper( $method )][$regexp] = $callback;
    }

    /**
     * Merge matches with a variables array
     *
     * Ignores all numeric keys in the matches array
     *
     * @param array $variables
     * @param array $matches
     * @return array
     */
    protected function mergeMatches( array $variables, array $matches )
    {
        foreach ( $matches as $key => $value )
        {
            if ( is_int( $key ) )
            {
                continue;
            }

            $variables[$key] = $value;
        }

        return $variables;
    }

    /**
     * Return routing information
     *
     * Based on the provided request and maybe on the router configuration this
     * method returns a valid callback to the controller which should be used
     * to fullfil the reuqest.
     *
     * @param Request $request
     * @return Callback
     */
    public function getRoutingInformation( Request $request )
    {
        if ( !isset( $this->routes[$request->method] ) )
        {
            throw new \UnexpectedValueException( "No routes found for the request method {$request->method}." );
        }

        foreach ( $this->routes[$request->method] as $regexp => $callback )
        {
            if ( preg_match( $regexp, $request->path, $matches ) )
            {
                $request->variables = $this->mergeMatches( $request->variables, $matches );
                return $callback;
            }
        }

        throw new \UnexpectedValueException( "No route found for request {$request->path}." );
    }
}

