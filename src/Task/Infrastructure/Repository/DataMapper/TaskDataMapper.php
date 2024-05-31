<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Infrastructure\Repository\DataMapper;

use ScheduleApiRemastered\Task\Business\Domain\Task;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskAssigneeId;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskDescription;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskDueDate;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskGuid;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskStatus;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskTitle;

class TaskDataMapper
{
    /**
     * @return Task[]
     */
    public function mapMany(array $result): array
    {
        $tasks = [];
        foreach ($result as $row) {
            $tasks[] = $this->mapOne($row);
        }

        return $tasks;
    }

    public function mapOne(array $result): Task
    {
        return new Task(
            new TaskGuid($result['guid']),
            new TaskTitle($result['title']),
            new TaskDescription($result['description']),
            new TaskAssigneeId($result['assigneeId']),
            TaskStatus::from($result['status']),
            new TaskDueDate($result['dueDate'])
        );
    }
}
