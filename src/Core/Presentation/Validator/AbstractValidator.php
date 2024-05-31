<?php

declare(strict_types=1);

namespace App\Core\Presentation\Validator;

use App\Core\Presentation\Validator\Exception\ValidationException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractValidator
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function validate(array $data): void
    {
        $violationList = $this->validator->validate($data, $this->getConstraints());

        if ($violationList->count() > 0) {
            throw ValidationException::withViolationList($violationList);
        }
    }

    abstract protected function getConstraints(): Constraint;
}
