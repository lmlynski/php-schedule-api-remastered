<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Cli;

use ScheduleApiRemastered\Task\Business\Service\TaskService;
use ScheduleApiRemastered\Task\Presentation\Cli\InputHandler\DeleteTaskInputHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteTaskCommand extends Command
{
    protected static $defaultName = 'app:task:delete';

    public function __construct(
        private readonly TaskService $service,
        private readonly DeleteTaskInputHandler $inputHandler,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Delete task.')
            ->addArgument('guid', InputArgument::REQUIRED, 'Task guid');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->service->delete($this->inputHandler->getCommand($input));

        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->success('Task successfully deleted.');

        return Command::SUCCESS;
    }
}
