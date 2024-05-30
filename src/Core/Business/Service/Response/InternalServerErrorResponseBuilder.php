<?php

declare(strict_types=1);

namespace App\Core\Business\Service\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InternalServerErrorResponseBuilder implements ErrorResponseBuilderInterface
{
    private const KEY_ERROR_MESSAGE = 'errorMessage';
    private const ERROR_MESSAGE = 'Internal server error';

    public function supports(Throwable $throwable): bool
    {
        return true; // the fallback one
    }

    public function build(Throwable $throwable): JsonResponse
    {
        return new JsonResponse(
            [
                self::KEY_ERROR_MESSAGE => self::ERROR_MESSAGE
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
