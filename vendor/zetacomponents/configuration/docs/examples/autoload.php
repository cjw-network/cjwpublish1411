<?php

require_once 'Base/trunk/src/base.php';

/**
 * Autoload ezc classes 
 * 
 * @param string $className 
 */
function __autoload( $className )
{
    if ( ezcBase::autoload( $className ) )
    {
        return;
    }
}
?>
