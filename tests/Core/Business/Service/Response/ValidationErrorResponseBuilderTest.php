<?php

declare(strict_types=1);

namespace App\Tests\Core\Business\Service\Response;

use App\Core\Business\Service\Response\ValidationErrorResponseBuilder;
use App\Core\Presentation\Validator\Exception\ValidationException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationErrorResponseBuilderTest extends TestCase
{
    public function testBuildWithNoViolationsWillReturnJsonResponseOnlyWithGeneralMessage(): void
    {
        $violationList = new ConstraintViolationList([]);
        $throwable = ValidationException::withViolationList($violationList);

        $builder = new ValidationErrorResponseBuilder();
        $result = $builder->build($throwable);

        self::assertInstanceOf(JsonResponse::class, $result);
        self::assertSame(400, $result->getStatusCode());
        self::assertIsArray(json_decode($result->getContent(), true));
    }

    public function testBuildWithViolationsWillReturnJsonResponseWithGeneralMessageAndForSpecificProperties(): void
    {
        $violations = [
            new ConstraintViolation(
                'message one',
                null,
                [],
                'root-one',
                'property-one',
                'invalid value one'
            ),
            new ConstraintViolation(
                'message two',
                null,
                [],
                'root-two',
                'property-two',
                'invalid value two'
            ),
        ];
        $violationList = new ConstraintViolationList($violations);
        $throwable = ValidationException::withViolationList($violationList);

        $builder = new ValidationErrorResponseBuilder();
        $result = $builder->build($throwable);

        self::assertInstanceOf(JsonResponse::class, $result);
        self::assertSame(400, $result->getStatusCode());
        self::assertIsArray(json_decode($result->getContent(), true));
        self::assertSame('Validation error.', json_decode($result->getContent(), true)['errorMessage']);
        self::assertSame(
            [
                [
                    'field' => 'property-one',
                    'message' => 'message one',
                ],
                [
                    'field' => 'property-two',
                    'message' => 'message two',
                ],
            ],
            json_decode($result->getContent(), true)['errors']
        );
    }
}
