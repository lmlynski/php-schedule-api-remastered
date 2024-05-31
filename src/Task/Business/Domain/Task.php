<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Domain;

use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskAssigneeId;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskDescription;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskDueDate;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskGuid;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskStatus;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskTitle;

class Task
{
    public function __construct(
        private readonly TaskGuid $guid,
        private readonly TaskTitle $title,
        private readonly TaskDescription $description,
        private readonly TaskAssigneeId $assigneeId,
        private TaskStatus $status,
        private readonly TaskDueDate $dueDate
    ) {
    }

    public function getGuid(): TaskGuid
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

    public function getAssigneeId(): TaskAssigneeId
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

    public function getDueDate(): TaskDueDate
    {
        return $this->dueDate;
    }
}
