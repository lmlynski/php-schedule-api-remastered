<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\RequestHandler;

use App\Task\Business\Command\DeleteTaskCommand;
use App\Task\Presentation\Validator\AddTaskValidator;
use Symfony\Component\HttpFoundation\Request;

readonly class DeleteTaskRequestHandler
{
    public function __construct(private AddTaskValidator $validator)
    {
    }

    public function getCommand(Request $request): DeleteTaskCommand
    {
        $requestData = [
            'guid' => $request->get('guid'),
        ];

        $this->validator->validate($requestData);

        return new DeleteTaskCommand($requestData['guid']);
    }
}
