<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Domain;

readonly class Criterion
{
    public function __construct(
        private string $field,
        private mixed $value,
        private string $operator = '='
    ) {
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }
}
