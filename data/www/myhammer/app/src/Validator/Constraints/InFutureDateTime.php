<?php
/*
 * This file is part of the MyHammer RESTful API
 *
 * Arslan Afzal <arslanafzal321@gmail.com>
 *
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/*
 * Constraint to return message on past date
 * @Annotation
 */
class InFutureDateTime extends Constraint
{
    /**
     * @var string $message
     */
    public $message = 'The DateTime must be in future.';
}