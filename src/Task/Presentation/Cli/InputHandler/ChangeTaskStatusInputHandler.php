<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Cli\InputHandler;

use ScheduleApiRemastered\Task\Business\Command\ChangeTaskStatusCommand;
use ScheduleApiRemastered\Task\Presentation\Validator\ChangeTaskStatusValidator;
use Symfony\Component\Console\Input\InputInterface;

readonly class ChangeTaskStatusInputHandler
{
    public function __construct(private ChangeTaskStatusValidator $validator)
    {
    }

    public function getCommand(InputInterface $input): ChangeTaskStatusCommand
    {
        $cliData = [
            'guid' => $input->getArgument('guid'),
            'status' => $input->getArgument('status'),
        ];

        $this->validator->validate($cliData);

        return ChangeTaskStatusCommand::fromArray($cliData);
    }
}
