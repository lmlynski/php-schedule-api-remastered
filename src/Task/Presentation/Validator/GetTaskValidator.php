<?php

declare(strict_types=1);

namespace App\Task\Presentation\Validator;

use App\Core\Presentation\Validation\AbstractValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

class GetTaskValidator extends AbstractValidator
{
    use ConstraintAwareTrait;

    protected function getConstraints(): Constraint
    {
        return new Constraints\Collection(
            [
                'guid' => self::guid(),
            ]
        );
    }
}
