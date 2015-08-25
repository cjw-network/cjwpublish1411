<?php
/**
 * File containing the ezcFeedIdElement class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class defining an identifier.
 *
 * @property string $id
 *                  The value of the identifier.
 * @property bool $isPermaLink
 *                The permanent link state of the identifier.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedIdElement extends ezcFeedElement
{
    /**
     * The identifier value.
     *
     * @var string
     */
    public $id;

    /**
     * The permanent link state of the identifier value.
     *
     * @var bool
     */
    public $isPermaLink;

    /**
     * Returns the id attribute.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->id . '';
    }
}
?>
