<?php

declare(strict_types=1);

namespace App\Task\Business\Query;

use App\Core\Business\Domain\Criterion;

class UserFilter
{
    private int $offset;
    private int $limit;
    /** @var Criterion[] */
    private array $criteria = [];

    public function __construct()
    {
        $this->offset = 0;
        $this->limit = 10;
    }

    public function setOffset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function addCriterion(Criterion $criterion): self
    {
        $this->criteria[] = $criterion;

        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getCriteria(): array
    {
        return $this->criteria;
    }
}
