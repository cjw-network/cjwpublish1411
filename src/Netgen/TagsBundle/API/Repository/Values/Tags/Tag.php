<?php

namespace Netgen\TagsBundle\API\Repository\Values\Tags;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * Class representing a tag
 *
 * @property-read mixed $id Tag ID
 * @property-read mixed $parentTagId Parent tag ID
 * @property-read mixed $mainTagId Main tag ID
 * @property-read string $keyword Tag keyword
 * @property-read int $depth The depth tag has in tag tree
 * @property-read string $pathString The path to this tag e.g. /1/6/21/42 where 42 is the current ID
 * @property-read \DateTime $modificationDate Tag modification date
 * @property-read string $remoteId A global unique ID of the tag
 */
class Tag extends ValueObject
{
    /**
     * Tag ID
     *
     * @var mixed
     */
    protected $id;

    /**
     * Parent tag ID
     *
     * @var mixed
     */
    protected $parentTagId;

    /**
     * Main tag ID
     *
     * Zero if tag is not a synonym
     *
     * @var mixed
     */
    protected $mainTagId;

    /**
     * Tag keyword
     *
     * @var string
     */
    protected $keyword;

    /**
     * The depth tag has in tag tree
     *
     * @var int
     */
    protected $depth;

    /**
     * The path to this tag e.g. /1/6/21/42 where 42 is the current ID
     *
     * @var string
     */
    protected $pathString;

    /**
     * Tag modification date
     *
     * @var \DateTime
     */
    protected $modificationDate;

    /**
     * A global unique ID of the tag
     *
     * @var string
     */
    protected $remoteId;
}
