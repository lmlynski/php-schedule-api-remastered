<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Exception;

use ScheduleApiRemastered\Core\Business\Exception\NotFoundException;

class TaskNotFoundException extends NotFoundException
{
    public static function forGuid(string $guid): self
    {
        return new self(sprintf('Task for guid "%s" not found', $guid));
    }
}
