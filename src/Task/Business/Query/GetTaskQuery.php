<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Query;

readonly class GetTaskQuery
{
    public function __construct(public string $guid)
    {
    }
}
