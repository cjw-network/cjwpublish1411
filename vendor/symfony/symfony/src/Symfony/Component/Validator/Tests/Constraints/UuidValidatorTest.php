<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Tests\Constraints;

use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Validator\Constraints\UuidValidator;
use Symfony\Component\Validator\Validation;

/**
 * @author Colin O'Dell <colinodell@gmail.com>
 */
class UuidValidatorTest extends AbstractConstraintValidatorTest
{
    protected function getApiVersion()
    {
        return Validation::API_VERSION_2_5;
    }

    protected function createValidator()
    {
        return new UuidValidator();
    }

    public function testNullIsValid()
    {
        $this->validator->validate(null, new Uuid());

        $this->assertNoViolation();
    }

    public function testEmptyStringIsValid()
    {
        $this->validator->validate('', new Uuid());

        $this->assertNoViolation();
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testExpectsStringCompatibleType()
    {
        $this->validator->validate(new \stdClass(), new Uuid());
    }

    /**
     * @dataProvider getValidStrictUuids
     */
    public function testValidStrictUuids($uuid)
    {
        $this->validator->validate($uuid, new Uuid());

        $this->assertNoViolation();
    }

    public function getValidStrictUuids()
    {
        return array(
            array('216fff40-98d9-11e3-a5e2-0800200c9a66'), // Version 1 UUID in lowercase
            array('216FFF40-98D9-11E3-A5E2-0800200C9A66'), // Version 1 UUID in UPPERCASE
            array('456daefb-5aa6-41b5-8dbc-068b05a8b201'), // Version 4 UUID in lowercase
            array('456DAEFb-5AA6-41B5-8DBC-068B05A8B201'), // Version 4 UUID in UPPERCASE
        );
    }

    /**
     * @dataProvider getInvalidStrictUuids
     */
    public function testInvalidStrictUuids($uuid)
    {
        $constraint = new Uuid(array(
            'message' => 'testMessage',
        ));

        $this->validator->validate($uuid, $constraint);

        $this->buildViolation('testMessage')
            ->setParameter('{{ value }}', '"'.$uuid.'"')
            ->assertRaised();
    }

    public function getInvalidStrictUuids()
    {
        return array(
            array('216fff40-98d9-11e3-a5e2-0800200c9a6'),     // Too few characters
            array('216fff40-98d9-11e3-a5e2-0800200c9a666'),   // Too many characters
            array('V16fff40-98d9-11e3-a5e2-0800200c9a66'),    // Invalid character 'V'
            array('2-16fff-4098d-911e3a5e20-800-200c9-a66'),  // Non-standard dash positions (randomly placed)

            // Non-standard UUIDs allowed by some other systems
            array('216f-ff40-98d9-11e3-a5e2-0800-200c-9a66'), // Non-standard dash positions (every 4 chars)
            array('216fff40-98d911e3-a5e20800-200c9a66'),     // Non-standard dash positions (every 8 chars)
            array('216fff4098d911e3a5e20800200c9a66'),        // No dashes at all
            array('{216fff40-98d9-11e3-a5e2-0800200c9a66}'),  // Wrapped with curly braces
        );
    }

    /**
     * @dataProvider getValidStrictUuids
     */
    public function testVersionConstraintIsValid($uuid)
    {
        $constraint = new Uuid(array(
            'versions' => array(Uuid::V1_MAC, Uuid::V4_RANDOM),
        ));

        $this->validator->validate($uuid, $constraint);

        $this->assertNoViolation();
    }

    /**
     * @dataProvider getValidStrictUuids
     */
    public function testVersionConstraintIsInvalid($uuid)
    {
        $constraint = new Uuid(array(
            'versions' => array(Uuid::V2_DCE, Uuid::V3_MD5),
            'message' => 'myMessage',
        ));

        $this->validator->validate($uuid, $constraint);

        $this->buildViolation('myMessage')
            ->setParameter('{{ value }}', '"'.$uuid.'"')
            ->assertRaised();
    }

    /**
     * @dataProvider getValidNonStrictUuids
     */
    public function testValidNonStrictUuids($uuid)
    {
        $constraint = new Uuid(array(
            'strict' => false,
        ));

        $this->validator->validate($uuid, $constraint);

        $this->assertNoViolation();
    }

    public function getValidNonStrictUuids()
    {
        return array(
            array('216fff40-98d9-11e3-a5e2-0800200c9a66'),    // Version 1 UUID in lowercase
            array('216FFF40-98D9-11E3-A5E2-0800200C9A66'),    // Version 1 UUID in UPPERCASE
            array('456daefb-5aa6-41b5-8dbc-068b05a8b201'),    // Version 4 UUID in lowercase
            array('456DAEFb-5AA6-41B5-8DBC-068B05A8B201'),    // Version 4 UUID in UPPERCASE

            // Non-standard UUIDs allowed by some other systems
            array('216f-ff40-98d9-11e3-a5e2-0800-200c-9a66'), // Non-standard dash positions (every 4 chars)
            array('216fff40-98d911e3-a5e20800-200c9a66'),     // Non-standard dash positions (every 8 chars)
            array('216fff4098d911e3a5e20800200c9a66'),        // No dashes at all
            array('{216fff40-98d9-11e3-a5e2-0800200c9a66}'),  // Wrapped with curly braces
        );
    }

    /**
     * @dataProvider getInvalidNonStrictUuids
     */
    public function testInvalidNonStrictUuids($uuid)
    {
        $constraint = new Uuid(array(
            'strict' => false,
            'message' => 'myMessage',
        ));

        $this->validator->validate($uuid, $constraint);

        $this->buildViolation('myMessage')
            ->setParameter('{{ value }}', '"'.$uuid.'"')
            ->assertRaised();
    }

    public function getInvalidNonStrictUuids()
    {
        return array(
            array('216fff40-98d9-11e3-a5e2-0800200c9a6'),    // Too few characters
            array('216fff40-98d9-11e3-a5e2-0800200c9a666'),  // Too many characters
            array('V16fff40-98d9-11e3-a5e2-0800200c9a66'),   // Invalid character 'V'
            array('2-16fff-4098d-911e3a5e20-800-200c9-a66'), // Non-standard dash positions (randomly placed)
        );
    }
}
