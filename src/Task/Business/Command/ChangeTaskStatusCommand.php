<?php

declare(strict_types=1);

namespace App\Task\Business\Command;

use App\Core\Business\Contract\CommandInterface;
use App\Task\Business\Domain\ValueObject\TaskStatus;

readonly class ChangeTaskStatusCommand implements CommandInterface
{
    public function __construct(
        public string $guid,
        public TaskStatus $status
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['guid'],
            TaskStatus::from($data['status'])
        );
    }
}
