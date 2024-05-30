<?php

declare(strict_types=1);

namespace App\Tests\Core\Business\Service;

use App\Core\Business\Contract\CommandHandlerInterface;
use App\Core\Business\Contract\CommandInterface;
use App\Core\Business\Exception\ConfigurationException;
use App\Core\Business\Service\CommandBus;
use App\Task\Business\Command\AddTaskCommand;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

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
            'some-guid',
            'some-title',
            'some-description',
            'some-assigneeId',
            'some-status',
            new DateTimeImmutable('2021-02-02')
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
