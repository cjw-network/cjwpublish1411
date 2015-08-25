<?php
/**
 * File containing the eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder\SectionFacetBuilder class.
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
 * Build a section facet.
 *
 * If provided the search service returns a SectionFacet. Which contains the counts for
 * content in the existing sections.
 *
 * @package eZ\Publish\API\Repository\Values\Content\Query
 */
class SectionFacetBuilder extends FacetBuilder
{
}
