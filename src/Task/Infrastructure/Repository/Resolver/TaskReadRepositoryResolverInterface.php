<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Infrastructure\Repository\Resolver;

use ScheduleApiRemastered\Task\Business\Contract\TaskRepositoryInterface;

interface TaskReadRepositoryResolverInterface
{
    public function get(): TaskRepositoryInterface;

    public function addRepository(TaskRepositoryInterface $repository): void;
}
