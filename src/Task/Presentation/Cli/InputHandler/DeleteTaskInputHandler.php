<?php

declare(strict_types=1);

namespace App\Task\Presentation\Cli\InputHandler;

use App\Task\Business\Command\DeleteTaskCommand;
use App\Task\Presentation\Validator\DeleteTaskValidator;
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
