<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Query;

final readonly class GetTaskQuery
{
    public function __construct(public string $guid)
    {
    }
}
