<?php

namespace Netgen\TagsBundle\API\Repository\Values\User\Limitation;

use eZ\Publish\API\Repository\Values\User\Limitation;

class TagLimitation extends Limitation
{
    const TAG = "Tag";

    /**
     * Returns the limitation identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return self::TAG;
    }
}
