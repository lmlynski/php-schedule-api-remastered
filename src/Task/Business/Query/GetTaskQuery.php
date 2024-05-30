<?php

declare(strict_types=1);

namespace App\Task\Business\Query;

readonly class GetTaskQuery
{
    public function __construct(public string $guid)
    {
    }
}
