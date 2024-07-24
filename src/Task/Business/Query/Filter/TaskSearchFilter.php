<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Query\Filter;

use ScheduleApiRemastered\Core\Business\Domain\Criterion;
use ScheduleApiRemastered\Core\Business\Domain\Page;

class TaskSearchFilter
{
    /** @var Criterion[] */
    private array $criteria = [];
    private Page $page;

    public function __construct()
    {
        $this->page = Page::default();
    }

    public function addCriterion(Criterion $criterion): self
    {
        $this->criteria[] = $criterion;

        return $this;
    }

    public function setPage(?int $pageNumber, ?int $limit): self
    {
        $this->page = Page::create($pageNumber, $limit);

        return $this;
    }

    /**
     * @return Criterion[]
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    public function getPage(): Page
    {
        return $this->page;
    }
}
