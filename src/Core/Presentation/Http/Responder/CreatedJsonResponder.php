<?php

declare(strict_types=1);

namespace App\Core\Presentation\Http\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreatedJsonResponder implements JsonResponderInterface
{
    public function respond(mixed $payload = null): JsonResponse
    {
        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}