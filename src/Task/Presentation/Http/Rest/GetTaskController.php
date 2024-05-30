<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\Rest;

use App\Task\Business\Service\TaskService;
use App\Task\Presentation\Http\RequestHandler\GetTaskRequestHandler;
use App\Task\Presentation\Http\Responder\GetTaskResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetTaskController extends AbstractController
{
    public function __construct(
        private readonly TaskService $service,
        private readonly GetTaskRequestHandler $requestHandler,
        private readonly GetTaskResponder $responder
    ) {
    }

    public function get(Request $request): JsonResponse
    {
        return $this->responder->respond(
            $this->service->get(
                $this->requestHandler->getQuery($request)
            )
        );
    }
}
