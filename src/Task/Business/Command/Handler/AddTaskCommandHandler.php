<?php

declare(strict_types=1);

namespace App\Task\Business\Command\Handler;

use App\Core\Business\Contract\CommandHandlerInterface;
use App\Core\Business\Contract\CommandInterface;
use App\Core\Business\Exception\ConfigurationException;
use App\Task\Business\Command\AddTaskCommand;
use App\Task\Business\Domain\Task;
use App\Task\Business\Domain\ValueObject\TaskDescription;
use App\Task\Business\Domain\ValueObject\TaskStatus;
use App\Task\Business\Domain\ValueObject\TaskTitle;
use App\Task\Infrastructure\Repository\Resolver\TaskWriteRepositoryResolverInterface;

class AddTaskCommandHandler implements CommandHandlerInterface
{
    private TaskWriteRepositoryResolverInterface $taskWriteRepositoryResolver;

    public function __construct(TaskWriteRepositoryResolverInterface $taskWriteRepositoryResolver)
    {
        $this->taskWriteRepositoryResolver = $taskWriteRepositoryResolver;
    }

    /**
     * @throws ConfigurationException
     */
    public function handle(CommandInterface $command): void
    {
        if (!$command instanceof AddTaskCommand) {
            throw new ConfigurationException('Should be AddTaskCommand');
        }

        $task = new Task(
            $command->guid,
            new TaskTitle($command->title),
            new TaskDescription($command->description),
            $command->assigneeId,
            TaskStatus::from($command->status),
            $command->dueDate
        );

        $this->taskWriteRepositoryResolver->get()->add($task);
    }
}
