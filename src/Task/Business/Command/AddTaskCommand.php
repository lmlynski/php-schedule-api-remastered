<?php

declare(strict_types=1);

namespace App\Task\Business\Command;

use App\Core\Business\Contract\CommandInterface;

readonly class AddTaskCommand implements CommandInterface
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
