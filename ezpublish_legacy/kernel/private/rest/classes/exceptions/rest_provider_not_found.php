<?php
/**
 * File containing the ezpRestProviderNotfoundException class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

class ezpRestProviderNotFoundException extends ezpRestException
{
    public function __construct( $providerName )
    {
        parent::__construct( "The API provider '{$providerName}' could not be found." );
    }
}
