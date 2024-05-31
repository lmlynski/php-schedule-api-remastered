<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Business\Query\Handler;

use DateTimeImmutable;
use ScheduleApiRemastered\Core\Business\Contract\UserGuidResolverInterface;
use ScheduleApiRemastered\Core\Business\Domain\Criterion;
use ScheduleApiRemastered\Task\Business\Domain\Task;
use ScheduleApiRemastered\Task\Business\Query\GetTaskListQuery;
use ScheduleApiRemastered\Task\Business\Query\GetTaskQuery;
use ScheduleApiRemastered\Task\Business\Query\UserFilter;
use ScheduleApiRemastered\Task\Infrastructure\Repository\Resolver\TaskReadRepositoryResolverInterface;

readonly class TaskQueryHandler
{
    public function __construct(
        private TaskReadRepositoryResolverInterface $taskReadRepositoryResolver,
        private UserGuidResolverInterface $userGuidResolverInterface
    ) {
    }

    public function get(GetTaskQuery $query): Task
    {
        return $this->taskReadRepositoryResolver->get()->findByGuid($query->guid);
    }

    /**
     * @return Task[]
     */
    public function findBy(GetTaskListQuery $query): array
    {
        $filter = new UserFilter();
        if ($query->status) {
            $filter->addCriterion(new Criterion('status', $query->status));
        }
        if ($query->assigneeId) {
            $filter->addCriterion(new Criterion('assigneeId', $query->assigneeId));
        }
        if ($query->dueDate) {
            $filter->addCriterion(new Criterion('dueDate', $query->dueDate));
        }

        return $this->taskReadRepositoryResolver->get()->findAllBy($filter);
    }

    /**
     * @return Task[]
     */
    public function getMyTodayTasks(): array
    {
        $filter = (new UserFilter())
            ->addCriterion(new Criterion('dueDate', (new DateTimeImmutable())->format('Y-m-d')))
            ->addCriterion(new Criterion('assigneeId', $this->userGuidResolverInterface->resolve()));

        return $this->taskReadRepositoryResolver->get()->findAllBy($filter);
    }
}
