<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Command;

use ScheduleApiRemastered\Core\Business\Contract\CommandInterface;

readonly class DeleteTaskCommand implements CommandInterface
{
    public function __construct(public string $guid)
    {
    }
}
