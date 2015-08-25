<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

/*!
  Contains all the error codes for the shop module.
  /deprecated Use eZError class constants instead
*/

eZDebug::writeWarning( "All the constants in " . __FILE__ . " are deprecated, use eZError class constants instead" );

/*!
 The object is not a product.
*/
define( 'EZ_ERROR_SHOP_OK', 0 );
define( 'EZ_ERROR_SHOP_NOT_A_PRODUCT', 1 );
define( 'EZ_ERROR_SHOP_BASKET_INCOMPATIBLE_PRODUCT_TYPE', 2 );
define( 'EZ_ERROR_SHOP_PREFERRED_CURRENCY_DOESNOT_EXIST', 3 );
define( 'EZ_ERROR_SHOP_PREFERRED_CURRENCY_INACTIVE', 4 );
?>
