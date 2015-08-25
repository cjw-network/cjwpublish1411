<?php
/**
 * File containing the Cache PurgeClientInterface class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\MVC\Symfony\Cache;

interface PurgeClientInterface
{
    /**
     * Triggers the cache purge $cacheElements.
     *
     * @param mixed $cacheElements Cache resource(s) to purge (e.g. array of URI to purge in a reverse proxy)
     *
     * @return void
     */
    public function purge( $cacheElements );

    /**
     * Purges all content elements currently in cache.
     *
     * @return void
     */
    public function purgeAll();
}
