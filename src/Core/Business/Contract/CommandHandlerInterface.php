<?php

declare(strict_types=1);

namespace App\Core\Business\Contract;

use App\Core\Business\Exception\ConfigurationException;

interface CommandHandlerInterface
{
    /**
     * @throws ConfigurationException
     */
    public function handle(CommandInterface $command): void;
}
