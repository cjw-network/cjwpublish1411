<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/**
 * Function to get template instance, load autoloads (operators) and set default settings.
 *
 * @deprecated Since 4.3, superseded by {@link eZTemplate::factory()}
 *             Will be kept for compatability in 4.x.
 * @param string $name (Not supported as it was prevoisly set on same instance anyway)
 * @return eZTemplate
 */
function templateInit( $name = false )
{
    eZDebug::writeStrict( 'Function templateInit() has been deprecated in 4.3 in favor of eZTemplate::factory()', 'Deprecation' );
    return eZTemplate::factory();
}


?>
