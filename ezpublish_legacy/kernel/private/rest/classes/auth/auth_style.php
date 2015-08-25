<?php
/**
 * File containing the ezpRestAuthenticationStyleInterface interface.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

interface ezpRestAuthenticationStyleInterface
{
    /**
     * Setting up the state to allow for later authentcation checks.
     *
     * @param ezcMvcRequest $request
     * @return void
     */
    public function setup( ezcMvcRequest $request );

    /**
     * Method to be run inside the runRequestFilters hook inside MvcTools.
     *
     * This method should take care of seting up proper redirections to MvcTools
     *
     * @return eZUser|ezcMvcInternalRedirect
     */
    public function authenticate( ezcAuthentication $auth, ezcMvcRequest $request );

    /**
     * Returns valid eZPublish user that has been authenticated by {@link self::authenticate()}
     * @return eZUser
     */
    public function getUser();

    /**
     * Registers the user that has been authenticated
     * @return void
     * @param eZUser $user
     */
    public function setUser( eZUser $user );
}
?>
