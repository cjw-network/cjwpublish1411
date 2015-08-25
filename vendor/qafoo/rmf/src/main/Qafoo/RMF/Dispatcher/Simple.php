<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Dispatcher;
use Qafoo\RMF\Dispatcher;
use Qafoo\RMF\Request;

/**
 * Dispatcher base class
 *
 * The dispatcher controls the application flow and is configured by the
 * ``Router`` and the ``View`` implementation. It then dispatches the
 * ``Request``.
 *
 * @version $Revision$
 */
class Simple extends Dispatcher
{
    /**
     * Dispatch the request
     *
     * Dispatches the request using the information from the router and paasing
     * the result to the view.
     *
     * @param Request $request
     * @return void
     */
    public function dispatch( Request $request )
    {
        try {
            $callback = $this->router->getRoutingInformation( $request );

            if ( !is_callable( $callback ) )
            {
                throw new \RuntimeException( "Invalid callback provided." );
            }

            $this->view->display(
                $request,
                call_user_func( $callback, $request )
            );
        }
        catch ( \Exception $e )
        {
            $this->view->display( $request, $e );
        }
    }
}

