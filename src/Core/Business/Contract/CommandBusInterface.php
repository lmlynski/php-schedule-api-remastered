<?php

declare(strict_types=1);

namespace App\Core\Business\Contract;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;

    public function registerHandler(string $commandClassName, CommandHandlerInterface $handler): void;
}
