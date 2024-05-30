<?php

declare(strict_types=1);

namespace App\Core\Business\Service;

use App\Core\Business\Contract\CommandBusInterface;
use App\Core\Business\Contract\CommandHandlerInterface;
use App\Core\Business\Contract\CommandInterface;
use App\Core\Business\Exception\ConfigurationException;

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
