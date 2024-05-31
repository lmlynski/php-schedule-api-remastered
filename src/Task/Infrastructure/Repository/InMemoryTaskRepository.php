<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Repository;

use App\Task\Business\Contract\TaskRepositoryInterface;
use App\Task\Business\Domain\Task;
use App\Task\Business\Domain\ValueObject\TaskAssigneeId;
use App\Task\Business\Domain\ValueObject\TaskDescription;
use App\Task\Business\Domain\ValueObject\TaskDueDate;
use App\Task\Business\Domain\ValueObject\TaskGuid;
use App\Task\Business\Domain\ValueObject\TaskStatus;
use App\Task\Business\Domain\ValueObject\TaskTitle;
use App\Task\Business\Exception\TaskNotFoundException;
use App\Task\Business\Query\UserFilter;

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
        $this->tasks[$task->getGuid()->value] = $task;
    }

    public function save(Task $task): void
    {
        $this->tasks[$task->getGuid()->value] = $task;
    }

    public function findAllBy(UserFilter $filter): array
    {
        $result = [];
        foreach ($this->tasks as $task) {
            foreach ($filter->getCriteria() as $criterion) {
                if ($task->{'get' . ucfirst($criterion->getField())}()->value !== $criterion->getValue()) {
                    continue 2;
                }
            }

            $result[] = $task;
        }

        return array_slice($result, $filter->getOffset(), $filter->getLimit());
    }

    public function delete(Task $task): void
    {
        unset($this->tasks[$task->getGuid()->value]);
    }

    public function setExampleData(): void
    {
        $this->tasks['19265534-5218-492f-9cfc-d051a0d2e8d0'] = new Task(
            new TaskGuid('19265534-5218-492f-9cfc-d051a0d2e8d0'),
            new TaskTitle('title one'),
            new TaskDescription('description one'),
            new TaskAssigneeId('5966c003-b09b-40a3-abc7-cfcb6c31a954'),
            TaskStatus::NEW,
            new TaskDueDate('2021-03-27')
        );
        $this->tasks['e6752afc-dd94-4128-aa48-4c13e032e9c4'] = new Task(
            new TaskGuid('e6752afc-dd94-4128-aa48-4c13e032e9c4'),
            new TaskTitle('title two'),
            new TaskDescription('description two'),
            new TaskAssigneeId('05fe9fbd-273b-4878-8d4b-349e50318c2d'),
            TaskStatus::DONE,
            new TaskDueDate('2021-04-09')
        );
        $this->tasks['4653997f-13db-4a7a-a2db-736f75b00185'] = new Task(
            new TaskGuid('4653997f-13db-4a7a-a2db-736f75b00185'),
            new TaskTitle('title three'),
            new TaskDescription('description three'),
            new TaskAssigneeId('ef5e8615-7b8a-4c25-9e85-b1e8241686c8'),
            TaskStatus::NEW,
            new TaskDueDate('2021-04-11')
        );
        $this->tasks['78cdd473-5ed7-451e-b0bf-546bd72e3b3c'] = new Task(
            new TaskGuid('78cdd473-5ed7-451e-b0bf-546bd72e3b3c'),
            new TaskTitle('title four'),
            new TaskDescription('description four'),
            new TaskAssigneeId('5966c003-b09b-40a3-abc7-cfcb6c31a954'),
            TaskStatus::IN_PROGRESS,
            new TaskDueDate('2021-03-27')
        );
    }
}
