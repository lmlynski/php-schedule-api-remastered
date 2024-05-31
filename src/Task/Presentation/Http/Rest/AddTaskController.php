<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Http\Rest;

use ScheduleApiRemastered\Core\Presentation\Http\Responder\CreatedJsonResponder;
use ScheduleApiRemastered\Task\Business\Service\TaskService;
use ScheduleApiRemastered\Task\Presentation\Http\RequestHandler\AddTaskRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddTaskController extends AbstractController
{
    public function __construct(
        private readonly TaskService $service,
        private readonly AddTaskRequestHandler $requestHandler,
        private readonly CreatedJsonResponder $responder,
    ) {
    }

    public function add(Request $request): JsonResponse
    {
        $this->service->add($this->requestHandler->getCommand($request));

        return $this->responder->respond();
    }
}
