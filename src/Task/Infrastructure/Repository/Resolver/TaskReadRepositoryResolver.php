<?php

declare(strict_types=1);

namespace App\Task\Infrastructure\Repository\Resolver;

use App\Core\Business\Exception\ConfigurationException;
use App\Task\Business\Contract\TaskRepositoryInterface;

class TaskReadRepositoryResolver implements TaskReadRepositoryResolverInterface
{
    /** @var TaskRepositoryInterface[] */
    private array $repositories = [];

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

        /** @noinspection PhpUnhandledExceptionInspection */
        throw ConfigurationException::withMessage(sprintf('Unsupported read repository type "%s"', $this->type));
    }

    public function addRepository(TaskRepositoryInterface $repository): void
    {
        $this->repositories[] = $repository;
    }
}
