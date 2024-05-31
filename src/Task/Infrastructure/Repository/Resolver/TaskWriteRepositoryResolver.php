<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Infrastructure\Repository\Resolver;

use ScheduleApiRemastered\Core\Business\Exception\ConfigurationException;
use ScheduleApiRemastered\Task\Business\Contract\TaskRepositoryInterface;

class TaskWriteRepositoryResolver implements TaskWriteRepositoryResolverInterface
{
    /** @var TaskRepositoryInterface[] */
    private array $repositories;

    public function __construct(private readonly string $type)
    {
    }

    public function get(): TaskRepositoryInterface
    {
        foreach ($this->repositories as $repository) {
            if ($repository->supports($this->type)) {
                return $repository;
            }
        }

        /* @noinspection PhpUnhandledExceptionInspection */
        throw ConfigurationException::withMessage(sprintf('Unsupported write repository type "%s"', $this->type));
    }

    public function addRepository(TaskRepositoryInterface $repository): void
    {
        $this->repositories[] = $repository;
    }
}
