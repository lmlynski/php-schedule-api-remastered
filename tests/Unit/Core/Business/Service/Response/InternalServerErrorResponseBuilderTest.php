<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Tests\Unit\Core\Business\Service\Response;

use Exception;
use PHPUnit\Framework\TestCase;
use ScheduleApiRemastered\Core\Business\Service\Response\InternalServerErrorResponseBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;

class InternalServerErrorResponseBuilderTest extends TestCase
{
    public function testBuildWillReturnJsonResponseWithSpecifiedMessage(): void
    {
        $builder = new InternalServerErrorResponseBuilder();
        $result = $builder->build(new Exception('Some error message.'));

        self::assertInstanceOf(JsonResponse::class, $result);
        self::assertSame(500, $result->getStatusCode());
        self::assertIsArray(json_decode($result->getContent(), true));
        self::assertSame('Internal server error', json_decode($result->getContent(), true)['errorMessage']);
    }
}
