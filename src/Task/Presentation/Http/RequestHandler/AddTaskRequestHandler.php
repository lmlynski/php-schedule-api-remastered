<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\RequestHandler;

use App\Task\Business\Command\AddTaskCommand;
use App\Task\Presentation\Validator\AddTaskValidator;
use Symfony\Component\HttpFoundation\Request;

readonly class AddTaskRequestHandler
{
    public function __construct(private AddTaskValidator $validator)
    {
    }

    public function getCommand(Request $request): AddTaskCommand
    {
        $requestData = (array)json_decode($request->getContent(), true);

        $this->validator->validate($requestData);

        return AddTaskCommand::fromArray($requestData);
    }
}
