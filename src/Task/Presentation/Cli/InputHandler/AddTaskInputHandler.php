<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Cli\InputHandler;

use ScheduleApiRemastered\Task\Business\Command\AddTaskCommand;
use ScheduleApiRemastered\Task\Presentation\Validator\AddTaskValidator;
use Symfony\Component\Console\Input\InputInterface;

readonly class AddTaskInputHandler
{
    public function __construct(private AddTaskValidator $validator)
    {
    }

    public function getCommand(InputInterface $input): AddTaskCommand
    {
        $cliData = [
            'title' => $input->getArgument('title'),
            'description' => $input->getArgument('description'),
            'assigneeId' => $input->getArgument('assigneeId'),
            'status' => $input->getArgument('status'),
            'dueDate' => $input->getArgument('dueDate'),
        ];

        $this->validator->validate($cliData);

        return AddTaskCommand::fromArray($cliData);
    }
}
