<?php

declare(strict_types=1);

namespace App\Task\Business\Command;

use App\Core\Business\Contract\CommandInterface;

readonly class DeleteTaskCommand implements CommandInterface
{
    public function __construct(public string $guid)
    {
    }
}
