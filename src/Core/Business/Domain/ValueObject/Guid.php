<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

readonly class Guid
{
    public function __construct(public string $value)
    {
        Assert::uuid($value, 'Invalid guid format given.');
    }

    public static function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
