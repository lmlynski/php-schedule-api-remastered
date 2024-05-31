<?php

declare(strict_types=1);

namespace App\Task\Business\Command\Handler;

use App\Core\Business\Contract\CommandHandlerInterface;
use App\Core\Business\Contract\CommandInterface;
use App\Core\Business\Domain\ValueObject\Guid;
use App\Core\Business\Exception\ConfigurationException;
use App\Task\Business\Command\AddTaskCommand;
use App\Task\Business\Domain\Task;
use App\Task\Business\Domain\ValueObject\TaskAssigneeId;
use App\Task\Business\Domain\ValueObject\TaskDescription;
use App\Task\Business\Domain\ValueObject\TaskDueDate;
use App\Task\Business\Domain\ValueObject\TaskGuid;
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
            new TaskGuid(Guid::generate()),
            new TaskTitle($command->title),
            new TaskDescription($command->description),
            new TaskAssigneeId($command->assigneeId),
            TaskStatus::from($command->status),
            new TaskDueDate($command->dueDate)
        );

        $this->taskWriteRepositoryResolver->get()->add($task);
    }
}
