<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\Rest;

use App\Task\Business\Query\Handler\TaskQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class MyTasksForTodayController extends AbstractController
{
    private TaskQueryHandler $taskQuery;

    public function __construct(
        TaskQueryHandler $taskQuery
    ) {
        $this->taskQuery = $taskQuery;
    }

    public function show(): JsonResponse
    {
        return new JsonResponse($this->taskQuery->getMyTodayTasks());
    }
}
