<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Validator;

use ScheduleApiRemastered\Core\Presentation\Validator\AbstractValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

class GetTaskListValidator extends AbstractValidator
{
    use ConstraintAwareTrait;

    protected function getConstraints(): Constraint
    {
        return new Constraints\Collection(
            [
                'fields' => [
                    'assigneeId' => new Constraints\Optional(
                        self::guid()
                    ),
                    'status' => new Constraints\Optional(
                        self::taskStatus()
                    ),
                    'dueDate' => new Constraints\Optional(
                        self::date()
                    ),
                ],
                'allowExtraFields' => true,
            ]
        );
    }
}
