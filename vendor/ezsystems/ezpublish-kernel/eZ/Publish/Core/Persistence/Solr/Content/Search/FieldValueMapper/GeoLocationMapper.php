<?php
/**
 * File containing the GeoLocationMapper class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\Persistence\Solr\Content\Search\FieldValueMapper;

use eZ\Publish\Core\Persistence\Solr\Content\Search\FieldValueMapper;
use eZ\Publish\SPI\Search\Field;
use eZ\Publish\SPI\Search\FieldType;

/**
 * Maps raw document field values to something Solr can index.
 */
class GeoLocationMapper extends FieldValueMapper
{
    /**
     * Check if field can be mapped
     *
     * @param \eZ\Publish\SPI\Search\Field $field
     *
     * @return boolean
     */
    public function canMap( Field $field )
    {
        return $field->type instanceof FieldType\GeoLocationField;
    }

    /**
     * Map field value to a proper Solr representation
     *
     * @param \eZ\Publish\SPI\Search\Field $field
     *
     * @return mixed
     */
    public function map( Field $field )
    {
        return $field->value["latitude"] . "," . $field->value["longitude"];
    }
}
