<?php

declare(strict_types=1);

namespace ScheduleApiRemastered\Core\Presentation\Validator\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends RuntimeException
{
    private ConstraintViolationListInterface $violationList;

    public static function withViolationList(ConstraintViolationListInterface $violationList): self
    {
        $validationException = new self('Validation error.');
        $validationException->violationList = $violationList;

        return $validationException;
    }

    public function getViolationList(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }
}
