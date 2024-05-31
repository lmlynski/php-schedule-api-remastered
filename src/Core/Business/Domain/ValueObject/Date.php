<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Domain\ValueObject;

use Webmozart\Assert\Assert;

readonly class Date
{
    public function __construct(public string $value)
    {
        Assert::regex($value, '/^(\d{4})-(\d{2})-(\d{2})$/', 'Invalid date given.');
    }
}
