<?php

namespace OboPlayground\Domain\Model\Employee;

use Ramsey\Uuid\Uuid;

final class EmployeeId
{
    /** @var string */
    private $employee_id;

    public function __construct(string $en_employee_id)
    {
        $this->employee_id = $en_employee_id;
    }

    public static function uniqueId()
    {
        return new self(Uuid::uuid4());
    }

    public function __toString()
    {
        return $this->employee_id;
    }

    public function equals(self $an_employee_id)
    {
        return $this->employee_id === $an_employee_id->employee_id;
    }
}
