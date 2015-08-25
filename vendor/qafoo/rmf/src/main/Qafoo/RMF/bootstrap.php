<?php
/**
 * This file is part of the Qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF;

spl_autoload_register(
    function ( $class )
    {
        if ( 0 === strpos( $class, __NAMESPACE__ ) )
        {
            include __DIR__ . '/../../' . strtr( $class, '\\', '/' ) . '.php';
        }
        else
        {
            include __DIR__ . '/../../../library/' . strtr( $class, '\\_', '/' ) . '.php';
        }
    }
);
