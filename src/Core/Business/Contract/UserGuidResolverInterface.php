<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Contract;

interface UserGuidResolverInterface
{
    public function resolve(): string;
}
