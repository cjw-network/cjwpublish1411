<?php
/**
 * File containing the ezcWebdavPluginConfiguration base class.
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
 * @package Webdav
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Base class for plugin configurations.
 *
 * A plugin must ship at least one class that extends this base class and will
 * be used by {@link ezcWebdavPluginRegistry} to configure the plugin on load.
 *
 * To activate (load) a plugin, the user must instantiate the plugin specific
 * defived configuration class and submit the instance to {@link
 * ezcWebdavPluginRegistry::registerPlugin()}.
 * 
 * @package Webdav
 * @version //autogen//
 */
abstract class ezcWebdavPluginConfiguration
{
    /**
     * Returns the hooks this plugin wants to assign to.
     *
     * This method is called by {@link ezcWebdavPluginRegistry}, as soon as the
     * plugin is registered to be used. The method must return a structured
     * array, representing the hooks the plugin want to be notified about.
     *
     * The returned array must be of the following structure:
     * <code>
     *  array(
     *      '<className>' => array(
     *          '<hookName>' => array(
     *              <callback1>,
     *              <callback2>,
     *          ),
     *          '<anotherHookName>' => array(
     *              <callback3>,
     *          ),
     *      ),
     *      '<secondClassName>' => array(
     *          '<thirdHookName>' => array(
     *              <callback1>,
     *              <callback3>,
     *          ),
     *      ),
     *  )
     * </code>
     * 
     * @return array
     */
    public abstract function getHooks();

    /**
     * Returns the namespace of this plugin.
     *
     * The namespace of a plugin is a unique identifier string that allows it
     * to be recognized bejond other plugins. The namespace is used to provide
     * storage for the plugin in the 
     * 
     * @return string
     */
    public abstract function getNamespace();

    /**
     * Initialize the plugin.
     *
     * This method is called after the server has be initialized to make the
     * plugin setup necessary objects and to retreive necessary information
     * from the server.
     * 
     * @return void
     */
    public function init()
    {
    }
}

?>
