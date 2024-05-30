<?php

declare(strict_types=1);

namespace App\Task\Business\Service;

use App\Core\Business\Contract\CommandBusInterface;
use App\Task\Business\Command\AddTaskCommand;
use App\Task\Business\Command\ChangeTaskStatusCommand;
use App\Task\Business\Command\DeleteTaskCommand;
use App\Task\Business\Domain\Task;
use App\Task\Business\Query\GetTaskListQuery;
use App\Task\Business\Query\GetTaskQuery;
use App\Task\Business\Query\Handler\TaskQueryHandler;

readonly class TaskService
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private TaskQueryHandler $queryHandler,
    ) {
    }

    public function changeStatus(ChangeTaskStatusCommand $command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function add(AddTaskCommand $command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function delete(DeleteTaskCommand $command): void
    {
        $this->commandBus->dispatch($command);
    }

    public function get(GetTaskQuery $query): Task
    {
        return $this->queryHandler->get($query);
    }

    /**
     * @return Task[]
     */
    public function findBy(GetTaskListQuery $query): array
    {
        return $this->queryHandler->findBy($query);
    }
}
