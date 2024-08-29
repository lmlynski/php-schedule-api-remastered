<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Tests\Unit\Core\Business\Service\Request;

use PHPUnit\Framework\TestCase;
use ScheduleApiRemastered\Core\Business\Service\Request\RequestAuthHeaderUserGuidResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestHeaderUserIdResolverTest extends TestCase
{
    public function testResolveWithEmptyAuthorizationHeaderWillReturnEmptyString(): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn(new Request());

        self::assertSame('', (new RequestAuthHeaderUserGuidResolver($requestStack))->resolve());
    }

    public function testResolveWithWrongValueInAuthorizationHeaderWillReturnEmptyString(): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn(new Request([], [], [], [], [], ['HTTP_AUTHORIZATION' => 'Wrong Value']));

        self::assertSame('', (new RequestAuthHeaderUserGuidResolver($requestStack))->resolve());
    }

    public function testResolveWithCorrectValueInAuthorizationHeaderWillReturnExtractedUserGuid(): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn(new Request([], [], [], [], [], ['HTTP_AUTHORIZATION' => 'Bearer example-guid']));

        self::assertSame('example-guid', (new RequestAuthHeaderUserGuidResolver($requestStack))->resolve());
    }
}
