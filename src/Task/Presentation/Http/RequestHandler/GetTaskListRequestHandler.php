<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Http\RequestHandler;

use ScheduleApiRemastered\Task\Business\Query\GetTaskListQuery;
use ScheduleApiRemastered\Task\Presentation\Validator\GetTaskListValidator;
use Symfony\Component\HttpFoundation\Request;

readonly class GetTaskListRequestHandler
{
    public function __construct(private GetTaskListValidator $validator)
    {
    }

    public function getQuery(Request $request): GetTaskListQuery
    {
        $requestData = [];
        $status = $request->query->get('status');
        $assigneeId = $request->query->get('assigneeId');
        $dueDate = $request->query->get('dueDate');
        $limit = $request->query->get('limit');
        $pageNumber = $request->query->get('page');

        if ($status !== null) {
            $requestData['status'] = $status;
        }
        if ($assigneeId !== null) {
            $requestData['assigneeId'] = $assigneeId;
        }
        if ($dueDate !== null) {
            $requestData['dueDate'] = $dueDate;
        }
        if ($limit !== null) {
            $requestData['limit'] = $limit;
            $limit = (int)$limit;
        }
        if ($pageNumber !== null) {
            $requestData['page'] = $pageNumber;
            $pageNumber = (int)$pageNumber;
        }

        $this->validator->validate($requestData);

        return new GetTaskListQuery($status, $assigneeId, $dueDate, $pageNumber, $limit);
    }
}
