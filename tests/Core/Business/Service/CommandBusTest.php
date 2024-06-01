<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Tests\Core\Business\Service;

use PHPUnit\Framework\TestCase;
use ScheduleApiRemastered\Core\Business\Contract\CommandHandlerInterface;
use ScheduleApiRemastered\Core\Business\Contract\CommandInterface;
use ScheduleApiRemastered\Core\Business\Exception\ConfigurationException;
use ScheduleApiRemastered\Core\Business\Service\CommandBus;
use ScheduleApiRemastered\Task\Business\Command\AddTaskCommand;

class CommandBusTest extends TestCase
{
    public function testDispatchWithNoHandlersRegisteredWillThrowConfigurationException(): void
    {
        self::expectException(ConfigurationException::class);

        (new CommandBus())->dispatch($this->createMock(CommandInterface::class));
    }

    /**
     * @throws ConfigurationException
     */
    public function testDispatchWithHandlerRegisteredWillExecuteRegisteredHandler(): void
    {
        $command = new AddTaskCommand(
            'some-title',
            'some-description',
            'some-assigneeId',
            'some-status',
            '2024-05-25'
        );

        $commandHandler = $this->createMock(CommandHandlerInterface::class);
        $commandHandler
            ->expects(self::once())
            ->method('handle')
            ->with($command);

        $commandBus = new CommandBus();
        $commandBus->registerHandler(get_class($command), $commandHandler);
        $commandBus->dispatch($command);
    }
}
