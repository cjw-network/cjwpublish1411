<?php
/**
 * File containing the content updater action class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\Persistence\Legacy\Content\Type\ContentUpdater;

use eZ\Publish\SPI\Persistence\Content\ContentInfo;
use eZ\Publish\Core\Persistence\Legacy\Content\Gateway as ContentGateway;

/**
 * Updater action base class
 */
abstract class Action
{
    /**
     * Content gateway
     *
     * @var \eZ\Publish\Core\Persistence\Legacy\Content\Gateway
     */
    protected $contentGateway;

    /**
     * Creates a new action
     *
     * @param \eZ\Publish\Core\Persistence\Legacy\Content\Gateway $contentGateway
     */
    public function __construct( ContentGateway $contentGateway )
    {
        $this->contentGateway = $contentGateway;
    }

    /**
     * Applies the action to the given $content
     *
     * @param \eZ\Publish\SPI\Persistence\Content\ContentInfo $contentInfo
     *
     * @return void
     */
    abstract public function apply( ContentInfo $contentInfo );
}
