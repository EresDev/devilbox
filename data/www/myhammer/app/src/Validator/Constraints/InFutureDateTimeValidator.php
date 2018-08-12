<?php
/*
 * This file is part of the MyHammer RESTful API
 *
 * Arslan Afzal <arslanafzal321@gmail.com>
 *
 */
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Given Datetime must always be greater than NOW
 */
class InFutureDateTimeValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value)
        {
            return;
        }

        //Remove the worry of input having string or DateTime
        if(is_string($value)){
            $value = new \DateTime($value);
        }

        // $value must be greater than current datetime
        //  if not, that is a violation
        if(new \DateTime() > $value)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }


    }
}