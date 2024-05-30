<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\View;

use App\Task\Business\Domain\Task;
use JsonSerializable;

 readonly class TaskView implements JsonSerializable
{
    public function __construct(private Task $task)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'guid' => $this->task->getGuid(),
            'title' => $this->task->getTitle(),
            'description' => $this->task->getDescription(),
            'assigneeId' => $this->task->getAssigneeId(),
            'status' => $this->task->getStatus(),
            'dueDate' => $this->task->getDueDate()->format('Y-m-d'),
        ];
    }
}