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
class AcceptHeader extends PropertyHandler
{
    /**
     * Name of Accept header to parse
     *
     * @var string
     */
    protected $key;

    /**
     * Default value to return, if Accept header is unparsable
     *
     * @var string
     */
    protected $default;

    /**
     * Construct from name of Accept header to parse
     *
     * @param string $key
     * @param string $default
     * @return void
     */
    public function __construct( $key, $default )
    {
        $this->key     = $key;
        $this->default = $default;
    }

    /**
     * Get value of property handler
     *
     * @return mixed
     */
    public function getValue()
    {
        $default = array( array(
            'value'    => $this->default,
            'priority' => 1.,
        ) );

        if ( !isset( $_SERVER[$this->key] ) )
        {
            return $default;
        }

        return $this->parse( $_SERVER[$this->key] ) ?: $default;
    }

    /**
     * Parse accept header
     *
     * Returns a sorted list of the available accept headers.
     *
     * @param string $header
     * @return array
     */
    protected function parse( $header )
    {
        if ( !preg_match_all(
                '(
                    (?P<value>[a-z*][a-z0-9_/*+.-]*)
                        (?:;q=(?P<priority>[0-9.]+))?
                 \\s*(?:,|$))ix', $header, $matches, PREG_SET_ORDER ) )
        {
            return false;
        }

        // Fill array structure containing the priority values.
        //
        // Also fill up a key array with the priority values, to sort the array
        // structures in a second pass by priority.
        $accept        = array();
        $priority      = array();
        $originalOrder = array();
        foreach ( $matches as $nr => $values )
        {
            $accept[] = array(
                'value' => ( isset( $values['value'] ) ? strtolower( $values['value'] ) : null ),
                'priority' => ( $priority[] = ( isset( $values['priority'] ) ? (float) $values['priority'] : 1. ) ),
            );
            $originalOrder[] = $nr;
        }

        // Sort array descending by priority array.
        array_multisort(
            $priority, SORT_NUMERIC, SORT_DESC,
            $originalOrder, SORT_NUMERIC, SORT_ASC,
            $accept
        );

        return $accept;
    }
}

