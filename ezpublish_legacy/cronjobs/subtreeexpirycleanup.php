<?php
/**
 * File containing the subtreeexpirycleanup.php cronjob
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 * @package kernel
 */

eZSubtreeCache::removeAllExpiryCacheFromDisk();

?>
