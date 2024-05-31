<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Command;

use ScheduleApiRemastered\Core\Business\Contract\CommandInterface;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskStatus;

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
