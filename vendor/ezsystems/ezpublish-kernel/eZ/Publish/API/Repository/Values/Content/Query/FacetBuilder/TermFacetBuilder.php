<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder\TermFacetBuilder class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 *
 * @package eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder
 */

namespace eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;

use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;

/**
 * Build a term facet.
 *
 * If provided the search service returns a TermFacet which contains the counts for
 * content containing terms in arbitrary fields
 *
 * @package eZ\Publish\API\Repository\Values\Content\Query
 */
class TermFacetBuilder extends FacetBuilder
{
}
