<?php
/**
 * File containing the abstract Field criterion visitor class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\Persistence\Elasticsearch\Content\Search\CriterionVisitor;

use eZ\Publish\Core\Persistence\Elasticsearch\Content\Search\CriterionVisitor;
use eZ\Publish\Core\Persistence\Elasticsearch\Content\Search\FieldMap;
use eZ\Publish\API\Repository\Values\Content\Query\CustomFieldInterface;

/**
 * Base class for Field criterion visitors
 */
abstract class Field extends FieldFilterBase
{
    /**
     * Field map
     *
     * @var \eZ\Publish\Core\Persistence\Elasticsearch\Content\Search\FieldMap
     */
    protected $fieldMap;

    /**
     * Create from FieldMap
     *
     * @param \eZ\Publish\Core\Persistence\Elasticsearch\Content\Search\FieldMap $fieldMap
     */
    public function __construct( FieldMap $fieldMap )
    {
        $this->fieldMap = $fieldMap;
    }

    /**
     * Get field type information
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Query\CustomFieldInterface $criterion
     * @return array
     */
    protected function getFieldTypes( CustomFieldInterface $criterion )
    {
        return $this->fieldMap->getFieldTypes( $criterion );
    }
}
