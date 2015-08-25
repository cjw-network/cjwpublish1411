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
 * View base class
 *
 * The view receives the ``Request`` and the return value from the controller
 * (which might be ``null``). The view will then display this result.
 *
 * @version $Revision$
 */
abstract class View
{
    /**
     * Display the controller result
     *
     * @param Request $request
     * @param mixed $result
     * @return void
     */
    abstract public function display( Request $request, $result );
}

