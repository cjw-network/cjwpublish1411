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
 * Router base class
 *
 * The Router descides which controller should be called based on the
 * information, which can be found in the ``Request``.
 *
 * @version $Revision$
 */
abstract class Router
{
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
    abstract public function getRoutingInformation( Request $request );
}

