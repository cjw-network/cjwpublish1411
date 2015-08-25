<?php
/**
 * File containing the Image converter
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter;

use eZ\Publish\Core\FieldType\Media\Type as MediaType;
use eZ\Publish\SPI\Persistence\Content\Type\FieldDefinition;
use eZ\Publish\Core\Persistence\Legacy\Content\StorageFieldDefinition;
use eZ\Publish\Core\FieldType\FieldSettings;

class Media extends BinaryFile
{
    /**
     * Factory for current class
     *
     * @note Class should instead be configured as service if it gains dependencies.
     *
     * @return Image
     */
    public static function create()
    {
        return new self;
    }

    /**
     * Converts field definition data in $fieldDef into $storageFieldDef
     *
     * @param \eZ\Publish\SPI\Persistence\Content\Type\FieldDefinition $fieldDef
     * @param \eZ\Publish\Core\Persistence\Legacy\Content\StorageFieldDefinition $storageDef
     */
    public function toStorageFieldDefinition( FieldDefinition $fieldDef, StorageFieldDefinition $storageDef )
    {
        parent::toStorageFieldDefinition( $fieldDef, $storageDef );

        $storageDef->dataText1 = ( isset( $fieldDef->fieldTypeConstraints->fieldSettings['mediaType'] )
            ? $fieldDef->fieldTypeConstraints->fieldSettings['mediaType']
            : MediaType::TYPE_HTML5_VIDEO );
    }

    /**
     * Converts field definition data in $storageDef into $fieldDef
     *
     * @param \eZ\Publish\Core\Persistence\Legacy\Content\StorageFieldDefinition $storageDef
     * @param \eZ\Publish\SPI\Persistence\Content\Type\FieldDefinition $fieldDef
     */
    public function toFieldDefinition( StorageFieldDefinition $storageDef, FieldDefinition $fieldDef )
    {
        parent::toFieldDefinition( $storageDef, $fieldDef );
        $fieldDef->fieldTypeConstraints->fieldSettings = new FieldSettings(
            array(
                'mediaType' => $storageDef->dataText1,
            )
        );
    }
}
