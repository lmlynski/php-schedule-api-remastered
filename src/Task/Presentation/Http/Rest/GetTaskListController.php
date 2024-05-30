<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\Rest;

use App\Task\Business\Service\TaskService;
use App\Task\Presentation\Http\RequestHandler\GetTaskListRequestHandler;
use App\Task\Presentation\Http\Responder\GetTaskListResponder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetTaskListController extends AbstractController
{
    public function __construct(
        private readonly TaskService $service,
        private readonly GetTaskListRequestHandler $requestHandler,
        private readonly GetTaskListResponder $responder
    ) {
    }

    public function get(Request $request): JsonResponse
    {
        return $this->responder->respond(
            $this->service->findBy(
                $this->requestHandler->getQuery($request)
            )
        );
    }
}
