<?php

declare(strict_types=1);

namespace App\Task\Business\Domain;

use App\Task\Business\Domain\ValueObject\TaskDescription;
use App\Task\Business\Domain\ValueObject\TaskStatus;
use App\Task\Business\Domain\ValueObject\TaskTitle;
use DateTimeImmutable;

class Task
{
    public function __construct(
        private readonly string $guid,
        private readonly TaskTitle $title,
        private readonly TaskDescription $description,
        private readonly string $assigneeId,
        private TaskStatus $status,
        private readonly DateTimeImmutable $dueDate
    ) {
    }

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function getTitle(): TaskTitle
    {
        return $this->title;
    }

    public function getDescription(): TaskDescription
    {
        return $this->description;
    }

    public function getAssigneeId(): string
    {
        return $this->assigneeId;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function setStatus(TaskStatus $status): void
    {
        $this->status = $status;
    }

    public function getDueDate(): DateTimeImmutable
    {
        return $this->dueDate;
    }
}
