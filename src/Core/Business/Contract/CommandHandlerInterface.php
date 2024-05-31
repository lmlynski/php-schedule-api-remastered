<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Contract;

use ScheduleApiRemastered\Core\Business\Exception\ConfigurationException;

interface CommandHandlerInterface
{
    /**
     * @throws ConfigurationException
     */
    public function handle(CommandInterface $command): void;
}
