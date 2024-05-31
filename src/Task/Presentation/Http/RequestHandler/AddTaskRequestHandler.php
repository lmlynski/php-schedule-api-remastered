<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Task\Presentation\Http\RequestHandler;

use ScheduleApiRemastered\Task\Business\Command\AddTaskCommand;
use ScheduleApiRemastered\Task\Presentation\Validator\AddTaskValidator;
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
