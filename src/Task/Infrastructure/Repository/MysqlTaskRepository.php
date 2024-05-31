<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Repository;

use App\Task\Business\Contract\TaskRepositoryInterface;
use App\Task\Business\Domain\Task;
use App\Task\Business\Exception\TaskNotFoundException;
use App\Task\Business\Query\UserFilter;
use App\Task\Infrastructure\Repository\DataMapper\TaskDataMapper;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;

class MysqlTaskRepository implements TaskRepositoryInterface
{
    private const string TYPE = 'mysql';

    public function __construct(
        private readonly EntityManager $entityManager,
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
        $task = $this->entityManager
            ->getConnection()
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
     * @throws Exception
     */
    public function add(Task $task): void
    {
        $this->entityManager
            ->getConnection()
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
        $this->entityManager
            ->getConnection()
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
        $tasks = $this->entityManager
            ->getConnection()
            ->fetchAllAssociative(
                sprintf(
                    'SELECT * FROM task WHERE %s LIMIT %d OFFSET %d',
                    implode(' AND ', $criteria),
                    $filter->getLimit(),
                    $filter->getOffset()
                ),
            );

        return $this->mapper->mapMany($tasks);
    }

    public function delete(Task $task): void
    {
    }
}
