<?php

declare(strict_types=1);

namespace App\Core\Business\Service\Response;

use App\Core\Presentation\Validation\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ValidationErrorResponseBuilder implements ErrorResponseBuilderInterface
{
    private const KEY_ERROR_MESSAGE = 'errorMessage';
    private const KEY_ERRORS = 'errors';
    private const KEY_FIELD = 'field';
    private const KEY_MESSAGE = 'message';

    public function supports(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }

    public function build(Throwable $throwable): JsonResponse
    {
        $body = [];
        /** @var ValidationException $throwable */
        $body[self::KEY_ERROR_MESSAGE] = $throwable->getMessage();
        foreach ($throwable->getViolationList() as $violation) {
            $body[self::KEY_ERRORS][] = [
                self::KEY_FIELD => $violation->getPropertyPath(),
                self::KEY_MESSAGE => $violation->getMessage()
            ];
        }

        return new JsonResponse($body, Response::HTTP_BAD_REQUEST);
    }
}
