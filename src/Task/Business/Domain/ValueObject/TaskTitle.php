<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Domain\ValueObject;

use Webmozart\Assert\Assert;

final readonly class TaskTitle
{
    public const int MIN_LENGTH = 3;
    public const int MAX_LENGTH = 40;

    public function __construct(public string $value)
    {
        Assert::lengthBetween($value, self::MIN_LENGTH, self::MAX_LENGTH, 'Invalid Task title length.');
    }
}
