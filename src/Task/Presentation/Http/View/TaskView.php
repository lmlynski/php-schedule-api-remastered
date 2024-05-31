<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Http\View;

use JsonSerializable;
use ScheduleApiRemastered\Task\Business\Domain\Task;

readonly class TaskView implements JsonSerializable
{
    public function __construct(private Task $task)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'guid' => $this->task->getGuid()->value,
            'title' => $this->task->getTitle()->value,
            'description' => $this->task->getDescription()->value,
            'assigneeId' => $this->task->getAssigneeId()->value,
            'status' => $this->task->getStatus()->value,
            'dueDate' => $this->task->getDueDate()->value,
        ];
    }
}
