<?php

declare(strict_types=1);

namespace App\Task\Business\Exception;

use App\Core\Business\Exception\NotFoundException;

class TaskNotFoundException extends NotFoundException
{
    public static function forGuid(string $guid): self
    {
        return new static(sprintf('Task for guid "%s" not found', $guid));
    }
}
