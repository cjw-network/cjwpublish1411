<?php
/**
 * File containing the ObjectStateGroup class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.11.1
 */

namespace eZ\Publish\API\Repository\Values\ObjectState;

use eZ\Publish\API\Repository\Values\ValueObject;

/**
 * This class represents an object state group value
 *
 * @property-read mixed $id the id of the content type group
 * @property-read string $identifier the identifier of the content type group
 * @property-read string $defaultLanguageCode, the default language code of the object state group names and description used for fallback.
 * @property-read string[] $languageCodes the available languages
 */
abstract class ObjectStateGroup extends ValueObject
{
    /**
     * Primary key
     *
     * @var mixed
     */
    protected $id;

    /**
     * Readable string identifier of a group
     *
     * @var string
     */
    protected $identifier;

    /**
     * The default language code
     *
     * @var string
     */
    protected $defaultLanguageCode;

    /**
     * The available language codes for names an descriptions
     *
     * @var string[]
     */
    protected $languageCodes;

    /**
     * This method returns the human readable name in all provided languages
     * of the content type
     *
     * The structure of the return value is:
     * <code>
     * array( 'eng' => '<name_eng>', 'de' => '<name_de>' );
     * </code>
     *
     * @return string[]
     */
    abstract public function getNames();

    /**
     * This method returns the name of the content type in the given language
     *
     * @param string $languageCode
     *
     * @return string the name for the given language or null if none exists.
     */
    abstract public function getName( $languageCode );

    /**
     * This method returns the human readable description of the content type
     *
     * The structure of this field is:
     * <code>
     * array( 'eng' => '<description_eng>', 'de' => '<description_de>' );
     * </code>
     *
     * @return string[]
     */
    abstract public function getDescriptions();

    /**
     * This method returns the name of the content type in the given language
     *
     * @param string $languageCode
     *
     * @return string the description for the given language or null if none exists.
     */
    abstract public function getDescription( $languageCode );

}
