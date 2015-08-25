<?php
/**
 * This file is part of the qafoo RMF component.
 *
 * @version $Revision$
 * @copyright Copyright (c) 2011 Qafoo GmbH
 * @license Dual licensed under the MIT and GPL licenses.
 */

namespace Qafoo\RMF\Request\PropertyHandler;

/**
 * Property handler for common server variables
 *
 * @version $Revision$
 */
class JsonBody extends RawBody
{
    /**
     * Get value of property handler;
     *
     * @return mixed
     */
    public function getValue()
    {
        if ( ( $result = json_decode( $content = parent::getValue() ) ) === null )
        {
            throw new JsonBody\ParsingException( "Could not parse JSON body: '$content'" );
        }

        return $result;
    }
}

