<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Repository;

use App\Task\Business\Contract\TaskRepositoryInterface;
use App\Task\Business\Domain\Task;
use App\Task\Business\Exception\TaskNotFoundException;
use App\Task\Business\Query\UserFilter;
use DateTimeImmutable;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;

class MysqlTaskRepository implements TaskRepositoryInterface
{
    private const string TYPE = 'mysql';

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
                    'guid' => $guid
                ]
            );

        if (empty($task)) {
            throw TaskNotFoundException::forGuid($guid);
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        return new Task(
            $task['guid'],
            $task['title'],
            $task['description'],
            $task['assigneeId'],
            $task['status'],
            new DateTimeImmutable($task['dueDate'])
        );
    }

    public function add(Task $task): void
    {
        $this->entityManager
            ->getConnection()
            ->executeStatement(
                'INSERT INTO task (guid, title, description, assigneeId, status, dueDate)
                VALUES (:guid, :title, :description, :assigneeId, :status, :dueDate)',
                [
                    'guid' => $task->getGuid(),
                    'title' => $task->getTitle(),
                    'description' => $task->getDescription(),
                    'assigneeId' => $task->getAssigneeId(),
                    'status' => $task->getStatus(),
                    'dueDate' => $task->getDueDate()->format('Y-m-d'),
                ]
            );
    }

    public function save(Task $task): void
    {
        $this->entityManager
            ->getConnection()
            ->executeStatement(
                'REPLACE INTO task (guid, title, description, assigneeId, status, dueDate)
                VALUES (:guid, :title, :description, :assigneeId, :status, :dueDate)',
                [
                    'guid' => $task->getGuid(),
                    'title' => $task->getTitle(),
                    'description' => $task->getDescription(),
                    'assigneeId' => $task->getAssigneeId(),
                    'status' => $task->getStatus(),
                    'dueDate' => $task->getDueDate()->format('Y-m-d'),
                ]
            );
    }

    public function findAllBy(UserFilter $filter): array
    {
        $criteria = [];
        foreach ($filter->getCriteria() as $criterion) {
            $criteria[] = $criterion->getField() . ' ' . $criterion->getOperator() . ' \'' . $criterion->getValue() . '\'';
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

        $result = [];
        foreach ($tasks as $task) {
            $result[] = new Task(
                $task['guid'],
                $task['title'],
                $task['description'],
                $task['assigneeId'],
                $task['status'],
                new DateTimeImmutable($task['dueDate'])
            );
        }

        return $result;
    }

    public function delete(Task $task): void
    {
    }
}
