<?php

declare(strict_types=1);

namespace App\Tests\Core\Business\Service\Response;

use App\Core\Business\Service\Response\NotFoundErrorResponseBuilder;
use App\Core\Business\Exception\NotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class NotFoundErrorResponseBuilderTest extends TestCase
{
    public function testBuildWillReturnJsonResponseWithSpecifiedMessage(): void
    {
        $builder = new NotFoundErrorResponseBuilder();
        $result = $builder->build(new NotFoundException('Some error message.'));

        self::assertInstanceOf(JsonResponse::class, $result);
        self::assertSame(404, $result->getStatusCode());
        self::assertIsArray(json_decode($result->getContent(), true));
        self::assertSame('Some error message.', json_decode($result->getContent(), true)['errorMessage']);
    }
}
