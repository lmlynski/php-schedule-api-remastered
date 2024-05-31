<?php

declare(strict_types=1);

namespace App\Task\Business\Domain\ValueObject;

use Webmozart\Assert\Assert;

final readonly class TaskDescription
{
    public const int MIN_LENGTH = 10;
    public const int MAX_LENGTH = 2000;

    public function __construct(public string $value)
    {
        Assert::lengthBetween($value, self::MIN_LENGTH, self::MAX_LENGTH, 'Invalid Task description length.');
    }
}
