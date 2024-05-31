<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Cli\InputHandler;

use ScheduleApiRemastered\Task\Business\Command\DeleteTaskCommand;
use ScheduleApiRemastered\Task\Presentation\Validator\DeleteTaskValidator;
use Symfony\Component\Console\Input\InputInterface;

readonly class DeleteTaskInputHandler
{
    public function __construct(private DeleteTaskValidator $validator)
    {
    }

    public function getCommand(InputInterface $input): DeleteTaskCommand
    {
        $cliData = [
            'guid' => $input->getArgument('guid'),
        ];

        $this->validator->validate($cliData);

        return new DeleteTaskCommand($cliData['guid']);
    }
}
