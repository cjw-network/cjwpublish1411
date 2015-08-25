<?php
/**
 * File containing the ezcMvcController class
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
 * Interface defining controller classes.
 *
 * Controllers process the client's request and returns variables usable by the
 * view-manager in an instance of an ezcMvcResult.  Controllers should not
 * access request variables directly but should use the passed ezcMvcRequest.
 * The process is done through the createResult() method, but is not limited to
 * use protected nor private methods. The result of running a controller is an
 * instance of ezcMvcResult.
 *
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
abstract class ezcMvcController
{
    /**
     * Contains the action to run
     * @var string
     */
    protected $action;

    /**
     * Contains the original request
     * @var ezcMvcRequest
     */
    protected $request;

    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Holds the router associated with the action
     *
     * @var ezcMvcRouter
     */
    private $router;

    /**
     * Creates a new controller object and sets all the request variables as class variables.
     *
     * @throws ezcMvcControllerException if the action method is empty
     * @param string        $action
     * @param ezcMvcRequest $request
     */
    public function __construct( $action, ezcMvcRequest $request )
    {
        if ( ezcBase::inDevMode() && ( !is_string( $action ) || strlen( $action ) == 0 ) )
        {
            throw new ezcMvcControllerException( "The '" . get_class( $this ) . "' controller requires an action." );
        }
        $this->action = $action;
        $this->setRequestVariables( $request );
    }

    /**
     * Sets the property $name to $value, all properties are readonly though so
     * an exception is thrown for every set.
     *
     * @throws ezcBasePropertyPermissionException if a read-only property is
     *         tried to be modified.
     *
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );
    }

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @ignore
     */
    public function __get( $name )
    {
        if ( isset( $this->properties[$name] ) )
        {
            return $this->properties[$name];
        }

        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Returns true if the property $name is set, otherwise false.
     *
     * @param string $name
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        return array_key_exists( $name, $this->properties );
    }

    /**
     * Sets the router associated with this request.
     *
     * @param ezcMvcRouter $router
     */
    public function setRouter( ezcMvcRouter $router )
    {
        $this->router = $router;
    }

    /**
     * Returns the router associated with this request.
     *
     * @return ezcMvcRouter
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Loops over all the variables in the request, and sets them as object properties.
     *
     * @param ezcMvcRequest $request
     */
    protected function setRequestVariables( ezcMvcRequest $request )
    {
        foreach ( $request->variables as $key => $value )
        {
            $this->properties[$key] = $value;
        }
        $this->request = $request;
    }

    /**
     * Creates a method name to call from an $action name.
     *
     * @param string $action
     * @return string
     */
    public static function createActionMethodName( $action )
    {
        $actionMethod = 'do' . preg_replace( '@[^A-Za-z]@', '', preg_replace( '@[A-Za-z]+@e', 'ucfirst( "\\0" )', $action ) );
        return $actionMethod;
    }

    /**
     * Runs the controller to process the query and return variables usable
     * to render the view.
     *
     * @throws ezcMvcActionNotFoundException if the action method could not be found
     * @return ezcMvcResult|ezcMvcInternalRedirect
     */
    public function createResult()
    {
        $actionMethod = self::createActionMethodName( $this->action );

        if ( method_exists( $this, $actionMethod ) )
        {
            return $this->$actionMethod();
        }
        throw new ezcMvcActionNotFoundException( $this->action );
    }
}
?>
