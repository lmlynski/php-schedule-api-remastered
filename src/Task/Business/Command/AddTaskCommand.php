<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Command;

use ScheduleApiRemastered\Core\Business\Contract\CommandInterface;

final readonly class AddTaskCommand implements CommandInterface
{
    public function __construct(
        public string $title,
        public string $description,
        public string $assigneeId,
        public string $status,
        public string $dueDate
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['description'],
            $data['assigneeId'],
            $data['status'],
            $data['dueDate']
        );
    }
}
