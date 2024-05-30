<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Repository;

use App\Task\Business\Contract\TaskRepositoryInterface;
use App\Task\Business\Domain\Task;
use App\Task\Business\Exception\TaskNotFoundException;
use App\Task\Business\Query\UserFilter;
use DateTimeImmutable;

class InMemoryTaskRepository implements TaskRepositoryInterface
{
    private const string TYPE = 'memory';

    private array $tasks = [];

    public function supports(string $type): bool
    {
        return $type === self::TYPE;
    }

    /**
     * @throws TaskNotFoundException
     */
    public function findByGuid(string $guid): Task
    {
        if (!empty($this->tasks[$guid])) {
            return $this->tasks[$guid];
        }

        throw TaskNotFoundException::forGuid($guid);
    }

    public function add(Task $task): void
    {
        $this->tasks[$task->getGuid()] = $task;
    }

    public function save(Task $task): void
    {
        $this->tasks[$task->getGuid()] = $task;
    }

    public function findAllBy(UserFilter $filter): array
    {
        $result = [];
        foreach ($this->tasks as $task) {
            if (empty($filter->getCriteria())) {
                continue;
            }
            foreach ($filter->getCriteria() as $criterion) {
                $value = $task->{'get' . ucfirst($criterion->getField())}();
                if ($value instanceof DateTimeImmutable) {
                    $value = $value->format('Y-m-d');
                }
                if ($value !== $criterion->getValue()) {
                    continue 2;
                }
            }

            $result[] = $task;
        }

        return array_slice($result, $filter->getOffset(), $filter->getLimit());
    }

    public function delete(Task $task): void
    {
        unset($this->tasks[$task->getGuid()]);
    }

    public function setExampleData(): void
    {
        $this->tasks['19265534-5218-492f-9cfc-d051a0d2e8d0'] = new Task(
            '19265534-5218-492f-9cfc-d051a0d2e8d0',
            'title one',
            'description one',
            '5966c003-b09b-40a3-abc7-cfcb6c31a954',
            'new',
            new DateTimeImmutable('2021-03-27')
        );
        $this->tasks['e6752afc-dd94-4128-aa48-4c13e032e9c4'] = new Task(
            'e6752afc-dd94-4128-aa48-4c13e032e9c4',
            'title two',
            'description two',
            '05fe9fbd-273b-4878-8d4b-349e50318c2d',
            'done',
            new DateTimeImmutable('2021-04-09')
        );
        $this->tasks['4653997f-13db-4a7a-a2db-736f75b00185'] = new Task(
            '4653997f-13db-4a7a-a2db-736f75b00185',
            'title three',
            'description three',
            'ef5e8615-7b8a-4c25-9e85-b1e8241686c8',
            'new',
            new DateTimeImmutable('2021-04-11')
        );
        $this->tasks['78cdd473-5ed7-451e-b0bf-546bd72e3b3c'] = new Task(
            '78cdd473-5ed7-451e-b0bf-546bd72e3b3c',
            'title four',
            'description four',
            '5966c003-b09b-40a3-abc7-cfcb6c31a954',
            'in_progress',
            new DateTimeImmutable('2021-03-27')
        );
    }
}
