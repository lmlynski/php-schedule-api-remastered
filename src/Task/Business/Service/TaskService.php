<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Service;

use ScheduleApiRemastered\Core\Business\Contract\CommandBusInterface;
use ScheduleApiRemastered\Task\Business\Command\AddTaskCommand;
use ScheduleApiRemastered\Task\Business\Command\ChangeTaskStatusCommand;
use ScheduleApiRemastered\Task\Business\Command\DeleteTaskCommand;
use ScheduleApiRemastered\Task\Business\Domain\Task;
use ScheduleApiRemastered\Task\Business\Query\GetTaskListQuery;
use ScheduleApiRemastered\Task\Business\Query\GetTaskQuery;
use ScheduleApiRemastered\Task\Business\Query\Handler\TaskQueryHandler;

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
