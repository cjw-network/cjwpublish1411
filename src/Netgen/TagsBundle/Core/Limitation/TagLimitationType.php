<?php

namespace Netgen\TagsBundle\Core\Limitation;

use eZ\Publish\Core\Limitation\AbstractPersistenceLimitationType;
use eZ\Publish\SPI\Persistence\Handler as SPIPersistenceHandler;
use eZ\Publish\API\Repository\Values\ValueObject;
use eZ\Publish\API\Repository\Values\User\User as APIUser;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentException;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use eZ\Publish\API\Repository\Values\User\Limitation as APILimitationValue;
use eZ\Publish\SPI\Limitation\Type as SPILimitationTypeInterface;
use eZ\Publish\Core\FieldType\ValidationError;
use eZ\Publish\API\Repository\Exceptions\NotFoundException;
use eZ\Publish\API\Repository\Exceptions\NotImplementedException;

use Netgen\TagsBundle\SPI\Persistence\Tags\Handler as SPITagsPersistenceHandler;
use Netgen\TagsBundle\API\Repository\Values\User\Limitation\TagLimitation as APITagLimitation;
use Netgen\TagsBundle\API\Repository\Values\Content\Query\Criterion\TagId;
use Netgen\TagsBundle\API\Repository\Values\Tags\Tag;

use RuntimeException;

class TagLimitationType extends AbstractPersistenceLimitationType implements SPILimitationTypeInterface
{
    /**
     * @var \Netgen\TagsBundle\SPI\Persistence\Tags\Handler
     */
    protected $tagsPersistence;

    /**
     * Constructor
     *
     * @param \eZ\Publish\SPI\Persistence\Handler $persistence
     * @param \Netgen\TagsBundle\SPI\Persistence\Tags\Handler $tagsPersistence
     */
    public function __construct( SPIPersistenceHandler $persistence, SPITagsPersistenceHandler $tagsPersistence )
    {
        parent::__construct( $persistence );

        $this->tagsPersistence = $tagsPersistence;
    }

    /**
     * Accepts a Limitation value and checks for structural validity.
     *
     * Makes sure LimitationValue object and ->limitationValues is of correct type.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException If the value does not match the expected type/structure
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $limitationValue
     */
    public function acceptValue( APILimitationValue $limitationValue )
    {
        if ( !$limitationValue instanceof APITagLimitation )
        {
            throw new InvalidArgumentType( "\$limitationValue", "TagLimitation", $limitationValue );
        }
        else if ( !is_array( $limitationValue->limitationValues ) )
        {
            throw new InvalidArgumentType( "\$limitationValue->limitationValues", "array", $limitationValue->limitationValues );
        }

        foreach ( $limitationValue->limitationValues as $key => $value )
        {
            if ( !is_int( $value ) && !ctype_digit( $value ) )
            {
                throw new InvalidArgumentType( "\$limitationValue->limitationValues[{$key}]", "int", $value );
            }
        }
    }

    /**
     * Makes sure LimitationValue->limitationValues is valid according to valueSchema().
     *
     * Make sure {@link acceptValue()} is checked first!
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $limitationValue
     *
     * @return \eZ\Publish\SPI\FieldType\ValidationError[]
     */
    public function validate( APILimitationValue $limitationValue )
    {
        $validationErrors = array();

        foreach ( $limitationValue->limitationValues as $key => $id )
        {
            try
            {
                $this->tagsPersistence->load( $id );
            }
            catch ( NotFoundException $e )
            {
                $validationErrors[] = new ValidationError(
                    "limitationValues[%key%] => '%value%' does not exist in the backend",
                    null,
                    array(
                        "value" => $id,
                        "key" => $key
                    )
                );
            }
        }

        return $validationErrors;
    }

    /**
     * Create the Limitation Value
     *
     * The is the method to create values as Limitation type needs value knowledge anyway in acceptValue,
     * the reverse relation is provided by means of identifier lookup (Value has identifier, and so does RoleService).
     *
     * @param mixed[] $limitationValues
     *
     * @return \eZ\Publish\API\Repository\Values\User\Limitation
     */
    public function buildValue( array $limitationValues )
    {
        return new APITagLimitation( array( 'limitationValues' => $limitationValues ) );
    }

    /**
     * Evaluate permission against content and placement
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException If any of the arguments are invalid
     *         Example: If LimitationValue is instance of ContentTypeLimitationValue, and Type is SectionLimitationType.
     * @throws \eZ\Publish\API\Repository\Exceptions\BadStateException If value of the LimitationValue is unsupported
     *         Example if OwnerLimitationValue->limitationValues[0] is not one of: [ 1,  2 ]
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $value
     * @param \eZ\Publish\API\Repository\Values\User\User $currentUser
     * @param \eZ\Publish\API\Repository\Values\ValueObject $object
     * @param \eZ\Publish\API\Repository\Values\ValueObject[]|null $targets An array of location, parent or "assignment"
     *                                                                 objects, if null: none where provided by caller
     *
     * @return boolean
     */
    public function evaluate( APILimitationValue $value, APIUser $currentUser, ValueObject $object, array $targets = null )
    {
        if ( !$value instanceof APITagLimitation )
        {
            throw new InvalidArgumentException( '$value', 'Must be of type: TagLimitation' );
        }

        if ( !$object instanceof Tag )
        {
            throw new InvalidArgumentException( '$object', 'Must be of type: Tag' );
        }

        if ( empty( $value->limitationValues ) )
        {
            return false;
        }

        return in_array( $object->id, $value->limitationValues );
    }

    /**
     * Returns Criterion for use in find() query
     *
     * @throws \RuntimeException If list of limitation values is empty
     *
     * @param \eZ\Publish\API\Repository\Values\User\Limitation $value
     * @param \eZ\Publish\API\Repository\Values\User\User $currentUser
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface
     */
    public function getCriterion( APILimitationValue $value, APIUser $currentUser )
    {
        if ( empty( $value->limitationValues ) )
        {
            // no limitation values
            throw new RuntimeException( "\$value->limitationValues is empty, it should not have been stored in the first place" );
        }

        if ( !isset( $value->limitationValues[1] ) )
        {
            // 1 limitation value: EQ operation
            return new TagId( $value->limitationValues[0] );
        }

        // several limitation values: IN operation
        return new TagId( $value->limitationValues );
    }

    /**
     * Returns info on valid $limitationValues

     * @throws \eZ\Publish\API\Repository\Exceptions\NotImplementedException If the limitation does not support
     *         value schema.
     *
     * @return mixed[]|int In case of array, a hash with key as valid limitations value and value as human readable name
     *                     of that option, in case of int on of VALUE_SCHEMA_* constants.
     *                     Note: The hash might be an instance of Traversable, and not a native php array.
     */
    public function valueSchema()
    {
        throw new NotImplementedException( __METHOD__ );
    }
}
