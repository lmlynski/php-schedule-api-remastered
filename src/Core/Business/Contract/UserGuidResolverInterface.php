<?php

declare(strict_types=1);

namespace App\Core\Business\Contract;

interface UserGuidResolverInterface
{
    public function resolve(): string;
}
