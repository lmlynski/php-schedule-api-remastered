<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Query;

final readonly class GetTaskListQuery
{
    public function __construct(
        public ?string $status = null,
        public ?string $assigneeId = null,
        public ?string $dueDate = null,
        public ?int $pageNumber = null,
        public ?int $limit = null
    ) {
    }
}
