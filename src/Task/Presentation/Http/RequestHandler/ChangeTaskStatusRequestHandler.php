<?php

declare(strict_types=1);

namespace App\Task\Presentation\Http\RequestHandler;

use App\Task\Business\Command\ChangeTaskStatusCommand;
use App\Task\Presentation\Validator\ChangeTaskStatusValidator;
use Symfony\Component\HttpFoundation\Request;

readonly class ChangeTaskStatusRequestHandler
{
    public function __construct(private ChangeTaskStatusValidator $validator)
    {
    }

    public function getCommand(Request $request): ChangeTaskStatusCommand
    {
        $requestData = array_merge(
            (array)json_decode($request->getContent(), true),
            [
                'guid' => $request->get('guid'),
            ]
        );
        $this->validator->validate($requestData);

        return ChangeTaskStatusCommand::fromArray($requestData);
    }
}
