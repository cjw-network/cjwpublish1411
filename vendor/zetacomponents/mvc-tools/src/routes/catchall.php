<?php
/**
 * File containing the ezcMvcCatchAllRoute class
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * Router class that acts like a catch all for /.../... type routes.
 *
 * The routes are matched against the uri property of the request object.
 *
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
class ezcMvcCatchAllRoute implements ezcMvcRoute
{
    /**
     * If url has no controller to match, use this as default.
     *
     * @var string
     */
    protected $controller;

    /**
     * If url has no action to match, use this as default.
     *
     * @var string
     */
    protected $action;

    /**
     * Only allow to catch routes that match at least this prefix.
     *
     * @var array
     */
    private $prefix = array();

    /**
     * Construct a CatchAll Route
     *
     * @param string $defaultController
     * @param string $defaultAction
     */
    public function __construct( $defaultController = 'index', $defaultAction = 'index' )
    {
        $this->controller = $defaultController;
        $this->action = $defaultAction;
    }

    /**
     * Returns the request information that the matches() method will match the
     * pattern against.
     *
     * @param ezcMvcRequest $request
     * @return string
     */
    protected function getUriString( ezcMvcRequest $request )
    {
        return $request->uri;
    }

    /**
     * Returns routing information if the route matched, or null in case the
     * route did not match.
     *
     * @param ezcMvcRequest $request Request to test.
     * @return null|ezcMvcRoutingInformation
     */
    public function matches( ezcMvcRequest $request )
    {
        $requestParts = explode( '/', $this->getUriString( $request ) );

        if ( !$this->checkPrefixMatch( $requestParts ) )
        {
            return null;
        }

        $params = array();
        $i = -1;
        foreach ( $requestParts as $part )
        {
            switch ( $i )
            {
                case -1:
                    // ignore, as it's the bit before the first /
                    break;
                case 0:
                    $this->controller = $part;
                    break;
                case 1:
                    $this->action = $part;
                    break;
                default:
                    $params[$this->createParamName( $i - 1 )] = $part;
            }
            $i++;
        }

        $controllerName = $this->createControllerName();
        if ( class_exists( $controllerName ) )
        {
            $actionMethod = call_user_func( array( $controllerName, 'createActionMethodName' ), $this->action );
            if ( !method_exists( $controllerName, $actionMethod ) )
            {
                return null;
            }
            $request->variables = array_merge( $request->variables, $params );
            return new ezcMvcRoutingInformation( $this->getUriString( $request ), $controllerName, $this->action );
        }
        return null;
    }

    /**
     * Create the param name from the indexed parameter
     *
     * @param  int $index
     * @return string
     */
    protected function createParamName( $index )
    {
        $paramName = 'param' . $index;
        return $paramName;
    }

    /**
     * Create the controller name from the matched name
     *
     * @return string
     */
    protected function createControllerName()
    {
        $controllerName = $this->controller . 'Controller';
        return $controllerName;
    }

    /**
     * Check if the prefix matches.
     *
     * @param  array $parts
     * @return boolean
     */
    protected function checkPrefixMatch( $parts )
    {
        for ( $i = 0; $i < count( $this->prefix ); $i++ )
        {
            if ( !isset( $parts[$i] ) || $parts[$i] !== $this->prefix[$i] )
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Adds a prefix to the route.
     *
     * @param string $prefix
     */
    public function prefix( $prefix )
    {
        $this->prefix = explode( '/', $prefix );
    }
}
?>
