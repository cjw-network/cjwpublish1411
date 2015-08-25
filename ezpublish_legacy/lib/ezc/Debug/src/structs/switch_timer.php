<?php

/**
 * File containing the ezcDebugSwitchTimerStruct.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Struct defining a timer switch.
 *
 * @package Debug
 * @version //autogentag//
 * @access private
 */
class ezcDebugSwitchTimerStruct extends ezcBaseStruct
{
    /**
     * The name of the timer took over the old timer.
     *
     * @var string
     */ 
    public $name;   

    /** 
     * The current time.
     *
     * @var float
     */
    public $time;   
}
?>
