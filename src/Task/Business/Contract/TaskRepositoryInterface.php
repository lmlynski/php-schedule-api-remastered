<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Contract;

use ScheduleApiRemastered\Task\Business\Domain\Task;
use ScheduleApiRemastered\Task\Business\Exception\TaskNotFoundException;
use ScheduleApiRemastered\Task\Business\Query\Filter\TaskSearchFilter;

interface TaskRepositoryInterface
{
    public function supports(string $type): bool;

    /**
     * @throws TaskNotFoundException
     */
    public function findByGuid(string $guid): Task;

    /**
     * @return Task[]
     */
    public function findAllBy(TaskSearchFilter $filter): array;

    public function add(Task $task): void;

    public function save(Task $task): void;

    public function delete(Task $task): void;
}
