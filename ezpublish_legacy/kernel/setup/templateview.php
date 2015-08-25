<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

// Redirect to visual module which is the correct place for this functionality
$module = $Params['Module'];
$parameters = $Params["Parameters"];

$visualModule = eZModule::exists( 'visual' );
if( $visualModule )
{
    return $module->forward( $visualModule, 'templateview', $parameters );
}

?>
