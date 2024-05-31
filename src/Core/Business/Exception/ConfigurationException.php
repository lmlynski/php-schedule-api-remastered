<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Exception;

use Exception;

class ConfigurationException extends Exception
{
    public static function withMessage(string $message): self
    {
        return new self($message);
    }
}
