<?php
/**
 * File containing the eZRedirectManager class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  \class eZRedirectManager ezredirectmanager.php
  \brief Handles generation of redirection URIs and redirection

*/

class eZRedirectManager
{

    /*!
     Generates a URI which can be used to redirect with, the uri is based on:
     - The last accessed view/non-view page if any (see \a $view parameter)
     - The uri is not the currently running module, if so use default
     - The default uri \a $default

     \return The new URI string or \c false if no uri could be made.

     \param $module The current module object
     \param $default The default URI to redirect to if all else fails.
                     If set to \c false then it will return false.
     \param $view If true it will try to redirect to last accessed view URI.
     \param $disallowed An array with urls not allowed to redirect to or \c false to allow all
     \param $preferredURI An URI that is preferred for the caller. If that URI is valid, it's returned.

     \note All URLs must start with a slash \c /

     \sa redirectTo()
    */
    static function redirectURI( $module, $default, $view = true, $disallowed = false, $preferredURI = false )
    {
        $uri = false;
        $http = eZHTTPTool::instance();

        if ( $preferredURI ) // check if $preferredURI is a valid URI
            return $preferredURI;

        if ( $view )
        {
            if ( $http->hasSessionVariable( "LastAccessesURI", false ) )
            {
                $uri = $http->sessionVariable( "LastAccessesURI" );
            }
        }
        else
        {
            if ( $http->hasSessionVariable( "LastAccessedModifyingURI", false ) )
            {
                $uri = $http->sessionVariable( "LastAccessedModifyingURI" );
            }
        }

        if ( $uri !== false )
        {
            $moduleURI = $module->functionURI( $module->currentView() );
            // Check for correct module/view
            if ( substr( $uri, 0, strlen( $moduleURI ) ) == $moduleURI )
            {
                // Check parameters
                $moduleURI = $module->currentRedirectionURI();
                if ( $moduleURI == $uri )
                    $uri = false;
            }
        }

        // Check for disallowed urls
        if ( $uri !== false and
             is_array( $disallowed ) )
        {
            if ( in_array( $uri, $disallowed ) )
                $uri = false;
        }

        if ( $uri === false )
        {
            // If no default is set we should return false.
            if ( $default === false )
                return false;
            $uri = $default;
        }

        return $uri;
    }

    /*!
     Generates a URI which can be used to redirect with, the uri is based on:
     - The last accessed view/non-view page if any (see \a $view parameter)
     - The uri is not the currently running module, if so use default
     - The default uri \a $default

     \param $module The current module object
     \param $default The default URI to redirect to if all else fails.
                     If set to \c false then it will not redirect if there is no url found
                     but instead it will return false.
     \param $view If true it will try to redirect to last accessed view URI.
     \param $disallowed An array with urls not allowed to redirect to or \c false to allow all
     \param $preferredURI An URI that is preferred for the caller.
            We redirect to that URI if it's specified and is valid.

     \return \c true if the module was redirected or \c false if not.

     \note All URLs must start with a slash \c /
     \sa redirectURI()
    */
    static function redirectTo( $module, $default, $view = true, $disallowed = false, $preferredURI = false )
    {
        $uri = eZRedirectManager::redirectURI( $module, $default, $view, $disallowed, $preferredURI );
        if ( $uri === false )
            return false;
        $module->redirectTo( $uri );
        return true;
    }
}

?>
