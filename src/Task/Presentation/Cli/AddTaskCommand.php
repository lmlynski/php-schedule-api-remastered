<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Cli;

use ScheduleApiRemastered\Task\Business\Service\TaskService;
use ScheduleApiRemastered\Task\Presentation\Cli\InputHandler\AddTaskInputHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddTaskCommand extends Command
{
    protected static string $defaultName = 'app:task:add';

    public function __construct(
        private readonly TaskService $service,
        private readonly AddTaskInputHandler $inputHandler,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Add new task.')
            ->addArgument('title', InputArgument::REQUIRED, 'Task title')
            ->addArgument('description', InputArgument::REQUIRED, 'Task description')
            ->addArgument('assigneeId', InputArgument::REQUIRED, 'Task assigneeId')
            ->addArgument('status', InputArgument::REQUIRED, 'Task status')
            ->addArgument('dueDate', InputArgument::REQUIRED, 'Task dueDate');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->service->add($this->inputHandler->getCommand($input));

        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->success('New task successfully added.');

        return Command::SUCCESS;
    }
}
