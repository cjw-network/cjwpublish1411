<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

$tpl = eZTemplate::factory();

$Result = array();
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/shop', 'Preferred currency' ),
                                'url' => false ) );
$Result['content'] = $tpl->fetch( "design:shop/preferredcurrency.tpl" );


?>
