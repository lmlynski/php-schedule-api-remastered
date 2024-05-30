<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Repository\Resolver;

use App\Task\Business\Contract\TaskRepositoryInterface;

interface TaskReadRepositoryResolverInterface
{
    public function get(): TaskRepositoryInterface;

    public function addRepository(TaskRepositoryInterface $repository): void;
}
