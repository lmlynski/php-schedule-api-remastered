<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Service\Response\Resolver;

use ScheduleApiRemastered\Core\Business\Exception\ConfigurationException;
use ScheduleApiRemastered\Core\Business\Service\Response\ErrorResponseBuilderInterface;
use Throwable;

class ErrorResponseBuilderResolver implements ErrorResponseBuilderResolverInterface
{
    /** @var ErrorResponseBuilderInterface[] */
    private array $builders = [];

    public function get(Throwable $throwable): ErrorResponseBuilderInterface
    {
        foreach ($this->builders as $builder) {
            if ($builder->supports($throwable)) {
                return $builder;
            }
        }

        /* @noinspection PhpUnhandledExceptionInspection */
        throw ConfigurationException::withMessage('Wrong error response builders configuration');
    }

    public function addBuilder(ErrorResponseBuilderInterface $errorResponseBuilder): void
    {
        $this->builders[] = $errorResponseBuilder;
    }
}
