<?php
/**
 * File containing the RouteReferenceGeneratorInterface class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\MVC\Symfony\Routing\Generator;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface for RouteReference generators.
 */
interface RouteReferenceGeneratorInterface
{
    /**
     * Injects the current request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setRequest( Request $request = null );

    /**
     * Generates a RouteReference, based on the given resource and associated params.
     * If $resource is null, generated route reference will be based on current request's route and parameters.
     *
     * @param mixed $resource The route name. Can be any resource supported by the different routers (e.g. Location object).
     * @param array $params Array of parameters, used to generate the final link along with $resource.
     *
     * @return \eZ\Publish\Core\MVC\Symfony\Routing\RouteReference
     */
    public function generate( $resource = null, array $params = array() );
}
