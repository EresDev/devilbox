<?php
/*
 * This file is part of the MyHammer RESTful API
 *
 * Arslan Afzal <arslanafzal321@gmail.com>
 *
 */
namespace App\Tests\Validator\Constraints;

use App\Validator\Constraints\InFutureDateTime;
use App\Validator\Constraints\InFutureDateTimeValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class InFutureDateTimeValidatorTest extends ConstraintValidatorTestCase
{
    /**
     * Get the validator ready as parent abstract class expects
     */
    protected function createValidator()
    {
        return new InFutureDateTimeValidator();
    }

    /**
     * We have no concern with input being null
     * if so, that is problem of isNull validator
     */
    public function testNullIsValid()
    {
        $this->validator->validate(null, new InFutureDateTime());
        $this->assertNoViolation();
    }

    /**
     * We have no concern with input being empty string
     * if so, that is problem of isEmpty validator
     */
    public function testEmptyStringIsValid()
    {
        $this->validator->validate('',  new InFutureDateTime());
        $this->assertNoViolation();
    }

    /**
     * Datetime in future must always pass
     */
    public function testValidFutureDate()
    {
        $this->validator->validate('2050-11-11 12:22:11',  new InFutureDateTime());
        $this->assertNoViolation();
    }

    /**
     * Datetime in past must always fail
     */
    public function testInvalidPastDate()
    {
        $this->validator->validate('2018-01-11 12:22:11',  new InFutureDateTime());
        $this->assertSame(1, $violationsCount = \count($this->context->getViolations()));
    }

}