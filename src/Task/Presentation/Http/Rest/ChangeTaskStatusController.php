<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Http\Rest;

use ScheduleApiRemastered\Core\Presentation\Http\Responder\NoContentJsonResponder;
use ScheduleApiRemastered\Task\Business\Service\TaskService;
use ScheduleApiRemastered\Task\Presentation\Http\RequestHandler\ChangeTaskStatusRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ChangeTaskStatusController extends AbstractController
{
    public function __construct(
        private readonly TaskService $service,
        private readonly ChangeTaskStatusRequestHandler $requestHandler,
        private readonly NoContentJsonResponder $responder,
    ) {
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $this->service->changeStatus($this->requestHandler->getCommand($request));

        return $this->responder->respond();
    }
}
