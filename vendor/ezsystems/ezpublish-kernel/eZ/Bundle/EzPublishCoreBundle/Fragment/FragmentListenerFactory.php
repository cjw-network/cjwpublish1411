<?php
/**
 * File containing the FragmentListenerFactory class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Bundle\EzPublishCoreBundle\Fragment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\UriSigner;

/**
 * Custom factory for Symfony FragmentListener.
 * Makes fragment paths SiteAccess aware (when in URI).
 */
class FragmentListenerFactory
{
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    public function setRequest( Request $request = null )
    {
        $this->request = $request;
    }

    public function buildFragmentListener( UriSigner $uriSigner, $fragmentPath, $fragmentListenerClass )
    {
        // Ensure that current pathinfo ends with configured fragment path.
        // If so, consider it as the fragment path.
        // This ensures to have URI siteaccess compatible fragment paths.
        $pathInfo = $this->request->getPathInfo();
        if ( substr( $pathInfo, -strlen( $fragmentPath ) ) === $fragmentPath )
        {
            $fragmentPath = $pathInfo;
        }

        $fragmentListener = new $fragmentListenerClass( $uriSigner, $fragmentPath );
        return $fragmentListener;
    }
}
