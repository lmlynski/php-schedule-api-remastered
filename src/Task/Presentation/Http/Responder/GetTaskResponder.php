<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\Responder;

use App\Core\Presentation\Http\Responder\JsonResponderInterface;
use App\Task\Business\Domain\Task;
use App\Task\Presentation\Http\View\TaskView;
use Symfony\Component\HttpFoundation\JsonResponse;

readonly class GetTaskResponder implements JsonResponderInterface
{
    /**
     * @param Task $payload
     */
    public function respond(mixed $payload = null): JsonResponse
    {
        return new JsonResponse(new TaskView($payload));
    }
}