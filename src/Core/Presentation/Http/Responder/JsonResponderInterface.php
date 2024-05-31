<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Presentation\Http\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;

interface JsonResponderInterface
{
    public function respond(mixed $payload = null): JsonResponse;
}
