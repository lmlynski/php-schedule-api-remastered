<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use ScheduleApiRemastered\Task\Business\Contract\TaskRepositoryInterface;
use ScheduleApiRemastered\Task\Business\Domain\Task;
use ScheduleApiRemastered\Task\Business\Exception\TaskNotFoundException;
use ScheduleApiRemastered\Task\Business\Query\UserFilter;
use ScheduleApiRemastered\Task\Infrastructure\Repository\DataMapper\TaskDataMapper;

class MysqlTaskRepository implements TaskRepositoryInterface
{
    private const string TYPE = 'mysql';

    public function __construct(
        private readonly Connection $connection,
        private readonly TaskDataMapper $mapper
    ) {
    }

    public function supports(string $type): bool
    {
        return $type === self::TYPE;
    }

    /**
     * @throws Exception
     * @throws TaskNotFoundException
     */
    public function findByGuid(string $guid): Task
    {
        $task = $this->connection
            ->fetchAssociative(
                'SELECT * FROM task WHERE guid = :guid',
                [
                    'guid' => $guid,
                ]
            );

        if (empty($task)) {
            throw TaskNotFoundException::forGuid($guid);
        }

        return $this->mapper->mapOne($task);
    }

    /**
     * @return Task[]
     *
     * @throws Exception
     */
    public function findAllBy(UserFilter $filter): array
    {
        $criteria = [];
        foreach ($filter->getCriteria() as $criterion) {
            $criteria[] = sprintf(
                '%s %s \'%s\'',
                $criterion->getField(),
                $criterion->getOperator(),
                $criterion->getValue()
            );
        }

        $tasks = $this->connection
            ->fetchAllAssociative(
                sprintf(
                    'SELECT * FROM task %s LIMIT %d OFFSET %d',
                    !empty($criteria) ? ('WHERE ' . implode(' AND ', $criteria)) : '',
                    $filter->getPage()->getLimit(),
                    $filter->getPage()->getOffset()
                ),
            );

        return $this->mapper->mapMany($tasks);
    }

    /**
     * @throws Exception
     */
    public function add(Task $task): void
    {
        $this->connection
            ->executeStatement(
                'INSERT INTO task (guid, title, description, assigneeId, status, dueDate)
                VALUES (:guid, :title, :description, :assigneeId, :status, :dueDate)',
                [
                    'guid' => $task->getGuid()->value,
                    'title' => $task->getTitle()->value,
                    'description' => $task->getDescription()->value,
                    'assigneeId' => $task->getAssigneeId()->value,
                    'status' => $task->getStatus()->value,
                    'dueDate' => $task->getDueDate()->value,
                ]
            );
    }

    /**
     * @throws Exception
     */
    public function save(Task $task): void
    {
        $this->connection
            ->executeStatement(
                'REPLACE INTO task (guid, title, description, assigneeId, status, dueDate)
                 VALUES (:guid, :title, :description, :assigneeId, :status, :dueDate)',
                [
                    'guid' => $task->getGuid()->value,
                    'title' => $task->getTitle()->value,
                    'description' => $task->getDescription()->value,
                    'assigneeId' => $task->getAssigneeId()->value,
                    'status' => $task->getStatus()->value,
                    'dueDate' => $task->getDueDate()->value,
                ]
            );
    }

    /**
     * @throws Exception
     */
    public function delete(Task $task): void
    {
        $this->connection
            ->executeStatement(
                'DELETE FROM task WHERE guid = :guid',
                [
                    'guid' => $task->getGuid()->value,
                ]
            );
    }
}
