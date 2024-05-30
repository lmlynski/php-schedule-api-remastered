<?php

declare(strict_types=1);

namespace App\Task\Business\Command\Handler;

use App\Core\Business\Contract\CommandHandlerInterface;
use App\Core\Business\Contract\CommandInterface;
use App\Core\Business\Exception\ConfigurationException;
use App\Task\Business\Command\ChangeTaskStatusCommand;
use App\Task\Business\Exception\TaskNotFoundException;
use App\Task\Infrastructure\Repository\Resolver\TaskWriteRepositoryResolverInterface;

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
