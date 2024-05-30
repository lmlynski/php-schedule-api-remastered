<?php

declare(strict_types=1);

namespace App\Core\Business\Service\Response;

use App\Core\Business\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class NotFoundErrorResponseBuilder implements ErrorResponseBuilderInterface
{
    private const string KEY_ERROR_MESSAGE = 'errorMessage';

    public function supports(Throwable $throwable): bool
    {
        return $throwable instanceof NotFoundException;
    }

    public function build(Throwable $throwable): JsonResponse
    {
        return new JsonResponse(
            [
                self::KEY_ERROR_MESSAGE => $throwable->getMessage(),
            ],
            Response::HTTP_NOT_FOUND
        );
    }
}
