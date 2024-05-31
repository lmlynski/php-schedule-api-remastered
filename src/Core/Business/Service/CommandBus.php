<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Service;

use ScheduleApiRemastered\Core\Business\Contract\CommandBusInterface;
use ScheduleApiRemastered\Core\Business\Contract\CommandHandlerInterface;
use ScheduleApiRemastered\Core\Business\Contract\CommandInterface;
use ScheduleApiRemastered\Core\Business\Exception\ConfigurationException;

class CommandBus implements CommandBusInterface
{
    /** @var CommandHandlerInterface[] */
    private array $handlers = [];

    /**
     * @throws ConfigurationException
     */
    public function dispatch(CommandInterface $command): void
    {
        if (!isset($this->handlers[get_class($command)])) {
            throw ConfigurationException::withMessage(
                sprintf('No handler registered for command "%s"', get_class($command))
            );
        }

        if (!$this->handlers[get_class($command)] instanceof CommandHandlerInterface) {
            throw ConfigurationException::withMessage(
                sprintf('Handler for command "%s" is wrong type', get_class($command))
            );
        }

        $this->handlers[get_class($command)]->handle($command);
    }

    public function registerHandler(string $commandClassName, CommandHandlerInterface $handler): void
    {
        $this->handlers[$commandClassName] = $handler;
    }
}
