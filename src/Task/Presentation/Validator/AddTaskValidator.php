<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Validator;

use ScheduleApiRemastered\Core\Presentation\Validator\AbstractValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

class AddTaskValidator extends AbstractValidator
{
    use ConstraintAwareTrait;

    protected function getConstraints(): Constraint
    {
        return new Constraints\Collection(
            [
                'title' => self::taskTitle(),
                'description' => self::taskDescription(),
                'assigneeId' => self::guid(),
                'status' => self::taskStatus(),
                'dueDate' => self::date(),
            ]
        );
    }
}
