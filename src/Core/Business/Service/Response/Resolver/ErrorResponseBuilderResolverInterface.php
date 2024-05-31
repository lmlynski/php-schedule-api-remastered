<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Service\Response\Resolver;

use ScheduleApiRemastered\Core\Business\Service\Response\ErrorResponseBuilderInterface;
use Throwable;

interface ErrorResponseBuilderResolverInterface
{
    public function get(Throwable $throwable): ErrorResponseBuilderInterface;

    public function addBuilder(ErrorResponseBuilderInterface $errorResponseBuilder): void;
}
