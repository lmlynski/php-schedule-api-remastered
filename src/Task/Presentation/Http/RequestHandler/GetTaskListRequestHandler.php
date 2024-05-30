<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\RequestHandler;

use App\Task\Business\Query\GetTaskListQuery;
use App\Task\Presentation\Validator\GetTaskListValidator;
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

        if ($status !== null) {
            $requestData['status'] = $status;
        }
        if ($assigneeId !== null) {
            $requestData['assigneeId'] = $assigneeId;
        }
        if ($dueDate !== null) {
            $requestData['dueDate'] = $dueDate;
        }

        $this->validator->validate($requestData);

        return new GetTaskListQuery($status, $assigneeId, $dueDate);
    }
}