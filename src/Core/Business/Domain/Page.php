<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Domain;

readonly class Page
{
    private const int DEFAULT_PAGE_NUMBER = 1;
    private const int DEFAULT_LIMIT = 20;

    public function __construct(
        private int $number = self::DEFAULT_PAGE_NUMBER,
        private int $limit = self::DEFAULT_LIMIT,
    ) {
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->number - 1;
    }

    public static function default(): self
    {
        return new self();
    }

    public static function create(?int $pageNumber, ?int $limit): self
    {
        if ($pageNumber === null && $limit === null) {
            return new self();
        }

        $pageNumber ??= self::DEFAULT_PAGE_NUMBER;
        $limit ??= self::DEFAULT_LIMIT;

        return new self($pageNumber, $limit);
    }
}
