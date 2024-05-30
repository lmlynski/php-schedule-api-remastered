<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\Rest;

use App\Core\Presentation\Http\Responder\NoContentJsonResponder;
use App\Task\Business\Service\TaskService;
use App\Task\Presentation\Http\RequestHandler\AddTaskRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AddTaskController extends AbstractController
{
    public function __construct(
        private readonly TaskService $service,
        private readonly AddTaskRequestHandler $requestHandler,
        private readonly NoContentJsonResponder $responder,
    ) {
    }

    public function add(Request $request): JsonResponse
    {
        $this->service->add($this->requestHandler->getCommand($request));

        return $this->responder->respond();
    }
}
