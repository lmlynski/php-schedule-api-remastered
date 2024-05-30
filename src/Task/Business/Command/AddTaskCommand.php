<?php

declare(strict_types=1);

namespace App\Task\Business\Command;

use App\Core\Business\Contract\CommandInterface;
use DateTimeImmutable;

readonly class AddTaskCommand implements CommandInterface
{
    public function __construct(
        public string $guid,
        public string $title,
        public string $description,
        public string $assigneeId,
        public string $status,
        public DateTimeImmutable $dueDate
    ) {
    }

    public static function fromArray(array $data): self
    {
        /* @noinspection PhpUnhandledExceptionInspection */
        return new self(
            $data['guid'],
            $data['title'],
            $data['description'],
            $data['assigneeId'],
            $data['status'],
            new DateTimeImmutable($data['dueDate'])
        );
    }
}
