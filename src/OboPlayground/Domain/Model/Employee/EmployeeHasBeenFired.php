<?php

namespace OboPlayground\Domain\Model\Employee;

use OboPlayground\Domain\Kernel\DomainEvent;

final class EmployeeHasBeenFired extends DomainEvent
{
    const EVENT_KEY = 'employee.hired';

    /** @var string */
    private $company_id;

    /** @var string */
    private $employee_id;

    public function __construct(string $a_company_id, string $an_employee_id)
    {
        parent::__construct();

        $this->company_id    = $a_company_id;
        $this->employee_id   = $an_employee_id;
    }
}
