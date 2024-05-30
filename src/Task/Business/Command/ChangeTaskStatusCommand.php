<?php

declare(strict_types=1);

namespace App\Task\Business\Command;

use App\Core\Business\Contract\CommandInterface;

readonly class ChangeTaskStatusCommand implements CommandInterface
{
    public function __construct(
        public string $guid,
        public string $status
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['guid'],
            $data['status']
        );
    }
}
