<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Repository\Resolver;

use App\Task\Business\Contract\TaskRepositoryInterface;

interface TaskWriteRepositoryResolverInterface
{
    public function get(): TaskRepositoryInterface;

    public function addRepository(TaskRepositoryInterface $repository): void;
}
