<?php

namespace App\Task\Infrastructure\Repository\DataMapper;

use App\Task\Business\Domain\Task;
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
        /** @noinspection PhpUnhandledExceptionInspection */
        return new Task(
            $result['guid'],
            $result['title'],
            $result['description'],
            $result['assigneeId'],
            $result['status'],
            new DateTimeImmutable($result['dueDate'])
        );
    }

}