<?php
/**
 * File containing the AuthorizerInterface class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace EzSystems\CommentsBundle\Comments;

use eZ\Publish\API\Repository\Values\Content\ContentInfo;

/**
 * Interface for comment authorizers that are based on Content.
 * Comments authorizers check if one can comment, based on ContentInfo.
 */
interface ContentAuthorizerInterface
{
    /**
     * Returns true if it comments can be appended to a content, based on its ContentInfo.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo
     *
     * @return bool
     */
    public function canCommentContent( ContentInfo $contentInfo );
}
