<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Command\Handler;

use ScheduleApiRemastered\Core\Business\Contract\CommandHandlerInterface;
use ScheduleApiRemastered\Core\Business\Contract\CommandInterface;
use ScheduleApiRemastered\Core\Business\Exception\ConfigurationException;
use ScheduleApiRemastered\Task\Business\Command\DeleteTaskCommand;
use ScheduleApiRemastered\Task\Business\Exception\TaskNotFoundException;
use ScheduleApiRemastered\Task\Infrastructure\Repository\Resolver\TaskWriteRepositoryResolverInterface;

class DeleteTaskCommandHandler implements CommandHandlerInterface
{
    private TaskWriteRepositoryResolverInterface $taskWriteRepositoryResolver;

    public function __construct(TaskWriteRepositoryResolverInterface $taskWriteRepositoryResolver)
    {
        $this->taskWriteRepositoryResolver = $taskWriteRepositoryResolver;
    }

    /**
     * @throws ConfigurationException
     * @throws TaskNotFoundException
     */
    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof DeleteTaskCommand) {
            throw new ConfigurationException('Should be DeleteTaskCommand');
        }

        $task = $this->taskWriteRepositoryResolver->get()->findByGuid($command->guid);
        $this->taskWriteRepositoryResolver->get()->delete($task);
    }
}
