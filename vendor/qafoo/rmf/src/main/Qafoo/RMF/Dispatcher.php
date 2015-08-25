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
 * Dispatcher base class
 *
 * The dispatcher controls the application flow and is configured by the
 * ``Router`` and the ``View`` implementation. It then dispatches the
 * ``Request``.
 *
 * @version $Revision$
 */
abstract class Dispatcher
{
    /**
     * Router to use
     *
     * @var Router
     */
    protected $router;

    /**
     * View handler to sue
     *
     * @var View
     */
    protected $view;

    /**
     * Construct from router and view
     *
     * @param Router $router
     * @param View $view
     * @return void
     */
    public function __construct( Router $router, View $view )
    {
        $this->router = $router;
        $this->view   = $view;
    }

    /**
     * Dispatch the request
     *
     * Dispatches the request using the information from the router and paasing
     * the result to the view.
     *
     * @param Request $request
     * @return void
     */
    abstract public function dispatch( Request $request );
}

