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
            new Constraints\Regex(
                [
                    'pattern' => '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
                    'message' => 'This value should be GUID format.'
                ]
            ),
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
            new Constraints\Date(
                [
                    'message' => 'This value should be date format.'
                ]
            )
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
            new Constraints\Length(['min' => 3, 'max' => 256])
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
            new Constraints\Length(['min' => 3, 'max' => 2000])
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
            new Constraints\Length(['min' => 3, 'max' => 2000])
        ];
    }
}