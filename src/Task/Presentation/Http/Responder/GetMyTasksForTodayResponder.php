<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Http\Responder;

use ScheduleApiRemastered\Core\Presentation\Http\Responder\JsonResponderInterface;
use ScheduleApiRemastered\Task\Business\Domain\Task;
use ScheduleApiRemastered\Task\Presentation\Http\View\TaskView;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class GetMyTasksForTodayResponder implements JsonResponderInterface
{
    /**
     * @param Task[] $payload
     */
    public function respond(mixed $payload = null): JsonResponse
    {
        $result = [];
        foreach ($payload as $task) {
            $result[] = new TaskView($task);
        }

        return new JsonResponse($result);
    }
}
