<?php

declare(strict_types=1);

namespace App\Task\Presentation\Cli\InputHandler;

use App\Task\Business\Command\ChangeTaskStatusCommand;
use App\Task\Presentation\Validator\ChangeTaskStatusValidator;
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
