<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Service\Event;

use Psr\Log\LoggerInterface;
use ScheduleApiRemastered\Core\Business\Service\Response\Resolver\ErrorResponseBuilderResolverInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

readonly class HttpExceptionEventListener
{
    public function __construct(
        private ErrorResponseBuilderResolverInterface $errorResponseBuilderResolver,
        private LoggerInterface $logger
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $event->allowCustomResponseCode();
        $exception = $event->getThrowable();

        $response = $this->errorResponseBuilderResolver->get($exception)->build($exception);
        if ($response->isServerError()) {
            $this->logger->error($exception->getMessage());
        }

        $event->setResponse($response);
    }
}
