<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Service\Request;

use ScheduleApiRemastered\Core\Business\Contract\UserGuidResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestAuthHeaderUserGuidResolver implements UserGuidResolverInterface
{
    private const string AUTHORIZATION_HEADER_KEY = 'Authorization';
    private const string BEARER_PREFIX = 'Bearer ';

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function resolve(): string
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $authHeaderValue = $currentRequest->headers->get(self::AUTHORIZATION_HEADER_KEY);

        if (empty($authHeaderValue)) {
            return '';
        }

        if (stripos($authHeaderValue, self::BEARER_PREFIX) !== 0) {
            return '';
        }

        return $this->extractUserGuidFromAuthorizationHeader($authHeaderValue);
    }

    private function extractUserGuidFromAuthorizationHeader(string $authHeaderValue): string
    {
        // to simplify we assume that token is user guid :)
        return str_ireplace(self::BEARER_PREFIX, '', $authHeaderValue);
    }
}
