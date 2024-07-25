<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Cli;

use ScheduleApiRemastered\Task\Business\Service\TaskService;
use ScheduleApiRemastered\Task\Presentation\Cli\InputHandler\ChangeTaskStatusInputHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ChangeTaskStatusCommand extends Command
{
    protected static string $defaultName = 'app:task:change_status';

    public function __construct(
        private readonly TaskService $service,
        private readonly ChangeTaskStatusInputHandler $inputHandler,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Change task status.')
            ->addArgument('guid', InputArgument::REQUIRED, 'Task guid')
            ->addArgument('status', InputArgument::REQUIRED, 'Task status');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->service->changeStatus($this->inputHandler->getCommand($input));

        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->success('Task status successfully changed.');

        return Command::SUCCESS;
    }
}
