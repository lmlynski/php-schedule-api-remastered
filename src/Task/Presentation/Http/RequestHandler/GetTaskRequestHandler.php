<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\RequestHandler;

use App\Task\Business\Query\GetTaskQuery;
use App\Task\Presentation\Validator\GetTaskValidator;
use Symfony\Component\HttpFoundation\Request;

readonly class GetTaskRequestHandler
{
    public function __construct(private GetTaskValidator $validator)
    {
    }

    public function getQuery(Request $request): GetTaskQuery
    {
        $requestData = [
            'guid' => $request->get('guid')
        ];

        $this->validator->validate($requestData);

        return new GetTaskQuery($requestData['guid']);
    }
}