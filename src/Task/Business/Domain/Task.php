<?php

declare(strict_types=1);

namespace App\Task\Business\Domain;

use DateTimeImmutable;

class Task
{
    public function __construct(
        private readonly string $guid,
        private readonly string $title,
        private readonly string $description,
        private readonly string $assigneeId,
        private string $status,
        private readonly DateTimeImmutable $dueDate
    ) {
    }

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAssigneeId(): string
    {
        return $this->assigneeId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getDueDate(): DateTimeImmutable
    {
        return $this->dueDate;
    }
}
