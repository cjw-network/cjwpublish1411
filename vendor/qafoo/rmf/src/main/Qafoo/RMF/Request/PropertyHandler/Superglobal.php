<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request\PropertyHandler;
use Qafoo\RMF\Request\PropertyHandler;

/**
 * Property handler for common server variables
 *
 * @version $Revision$
 */
class Superglobal extends PropertyHandler
{
    /**
     * Name of superglobal to expose
     *
     * @var string
     */
    protected $name;

    /**
     * Construct from name of superglobal
     *
     * @param string $name
     * @return void
     */
    public function __construct( $name )
    {
        $this->name = $name;
    }

    /**
     * Get value of property handler
     *
     * @return mixed
     */
    public function getValue()
    {
        if ( !isset( $GLOBALS[$this->name] ) )
        {
            throw new \InvalidArgumentException( "{$this->name} is not a superglobal variable." );
        }

        return $GLOBALS[$this->name];
    }
}

