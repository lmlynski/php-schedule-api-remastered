<?php

declare(strict_types=1);

namespace App\Task\Business\Command\Handler;

use App\Core\Business\Contract\CommandHandlerInterface;
use App\Core\Business\Contract\CommandInterface;
use App\Core\Business\Exception\ConfigurationException;
use App\Task\Business\Command\DeleteTaskCommand;
use App\Task\Business\Exception\TaskNotFoundException;
use App\Task\Infrastructure\Repository\Resolver\TaskWriteRepositoryResolverInterface;

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
