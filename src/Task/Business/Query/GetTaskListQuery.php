<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Query;

readonly class GetTaskListQuery
{
    public function __construct(
        public ?string $status,
        public ?string $assigneeId,
        public ?string $dueDate,
    ) {
    }
}
