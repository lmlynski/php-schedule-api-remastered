<?php

declare(strict_types=1);

namespace App\Task\Presentation\Cli\InputHandler;

use App\Task\Business\Command\AddTaskCommand;
use App\Task\Presentation\Validator\AddTaskValidator;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Input\InputInterface;

readonly class AddTaskInputHandler
{
    public function __construct(private AddTaskValidator $validator)
    {
    }

    public function getCommand(InputInterface $input): AddTaskCommand
    {
        $cliData = [
            'guid' => Uuid::uuid4()->toString(),
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
