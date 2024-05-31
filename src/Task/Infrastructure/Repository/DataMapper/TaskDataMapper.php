<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Repository\DataMapper;

use App\Task\Business\Domain\Task;
use App\Task\Business\Domain\ValueObject\TaskDescription;
use App\Task\Business\Domain\ValueObject\TaskStatus;
use App\Task\Business\Domain\ValueObject\TaskTitle;
use DateTimeImmutable;

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
        /* @noinspection PhpUnhandledExceptionInspection */
        return new Task(
            $result['guid'],
            new TaskTitle($result['title']),
            new TaskDescription($result['description']),
            $result['assigneeId'],
            TaskStatus::from($result['status']),
            new DateTimeImmutable($result['dueDate'])
        );
    }
}
