<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Command\Handler;

use ScheduleApiRemastered\Core\Business\Contract\CommandHandlerInterface;
use ScheduleApiRemastered\Core\Business\Contract\CommandInterface;
use ScheduleApiRemastered\Core\Business\Domain\ValueObject\Guid;
use ScheduleApiRemastered\Core\Business\Exception\ConfigurationException;
use ScheduleApiRemastered\Task\Business\Command\AddTaskCommand;
use ScheduleApiRemastered\Task\Business\Domain\Task;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskAssigneeId;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskDescription;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskDueDate;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskGuid;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskStatus;
use ScheduleApiRemastered\Task\Business\Domain\ValueObject\TaskTitle;
use ScheduleApiRemastered\Task\Infrastructure\Repository\Resolver\TaskWriteRepositoryResolverInterface;

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
