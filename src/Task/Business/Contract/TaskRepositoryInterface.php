<?php

declare(strict_types=1);

namespace App\Task\Business\Contract;

use App\Task\Business\Domain\Task;
use App\Task\Business\Exception\TaskNotFoundException;
use App\Task\Business\Query\UserFilter;

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
    public function findAllBy(UserFilter $filter): array;

    public function add(Task $task): void;

    public function save(Task $task): void;

    public function delete(Task $task): void;
}
