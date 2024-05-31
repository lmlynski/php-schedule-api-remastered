<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Command\Handler;

use ScheduleApiRemastered\Core\Business\Contract\CommandHandlerInterface;
use ScheduleApiRemastered\Core\Business\Contract\CommandInterface;
use ScheduleApiRemastered\Core\Business\Exception\ConfigurationException;
use ScheduleApiRemastered\Task\Business\Command\ChangeTaskStatusCommand;
use ScheduleApiRemastered\Task\Business\Exception\TaskNotFoundException;
use ScheduleApiRemastered\Task\Infrastructure\Repository\Resolver\TaskWriteRepositoryResolverInterface;

class ChangeTaskStatusCommandHandler implements CommandHandlerInterface
{
    private TaskWriteRepositoryResolverInterface $taskWriteRepositoryResolver;

    /**
     * @throws ConfigurationException
     * @throws TaskNotFoundException
     */
    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof ChangeTaskStatusCommand) {
            throw new ConfigurationException('Should be ChangeTaskStatusCommand');
        }

        $task = $this->taskWriteRepositoryResolver->get()->findByGuid($command->guid);
        $task->setStatus($command->status);
        $this->taskWriteRepositoryResolver->get()->save($task);
    }

    public function __construct(TaskWriteRepositoryResolverInterface $taskWriteRepositoryResolver)
    {
        $this->taskWriteRepositoryResolver = $taskWriteRepositoryResolver;
    }
}
