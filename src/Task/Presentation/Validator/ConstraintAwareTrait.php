<?php

declare(strict_types=1);

namespace App\Task\Presentation\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

trait ConstraintAwareTrait
{
    /**
     * @return Constraint[]
     */
    public static function guid(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Type('string'),
            new Constraints\Uuid(),
        ];
    }

    /**
     * @return Constraint[]
     */
    public static function date(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Type('string'),
            new Constraints\Date(),
        ];
    }

    /**
     * @return Constraint[]
     */
    public static function taskTitle(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Type('string'),
            new Constraints\Length(['min' => 3, 'max' => 40]),
        ];
    }

    /**
     * @return Constraint[]
     */
    public static function taskDescription(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Type('string'),
            new Constraints\Length(['min' => 10, 'max' => 2000]),
        ];
    }

    /**
     * @return Constraint[]
     */
    public static function taskStatus(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Type('string'),
            new Constraints\Choice(['new', 'in_progress', 'done']),
        ];
    }
}
