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
class Override extends PropertyHandler
{
    /**
     * Overriding property handlers
     *
     * @var array(PropertyHandler)
     */
    protected $innerHandlers = array();

    /**
     * Construct from array of overriding property handlers
     *
     * @param array $innerHandlers
     * @return void
     */
    public function __construct( array $innerHandlers = array() )
    {
        $this->innerHandlers = $innerHandlers;
    }

    /**
     * Get value of property handler
     *
     * @return mixed
     */
    public function getValue()
    {
        foreach ( $this->innerHandlers as $handler )
        {
            try
            {
                $value = $handler->getValue();
                return $value;
            }
            catch ( \Exception $e )
            {
                continue;
            }
        }

        throw new Override\NoValueFoundException();
    }
}

