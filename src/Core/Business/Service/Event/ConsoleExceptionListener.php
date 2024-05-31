<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Business\Service\Event;

use ScheduleApiRemastered\Core\Presentation\Validator\Exception\ValidationException;
use Symfony\Component\Console\Event\ConsoleErrorEvent;

readonly class ConsoleExceptionListener
{
    public function onConsoleError(ConsoleErrorEvent $event): void
    {
        $exception = $event->getError();
        $output = $event->getOutput();

        if ($exception instanceof ValidationException) {
            foreach ($exception->getViolationList() as $violation) {
                $output->writeln($violation->getPropertyPath() . ' : ' . $violation->getMessage());
            }
        }
    }
}
