<?php

namespace OboPlayground\Application\Service\Person;

use OboPlayground\Domain\Model\Employee\EmployedStatus;

final class ListPeopleRequest
{
    private $employed_status;

    public function __construct(string $an_employed_status)
    {
        $this->employed_status = $an_employed_status;
    }

    public function employedStatus()
    {
        return EmployedStatus::fromString($this->employed_status);
    }
}
