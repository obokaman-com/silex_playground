<?php

namespace OboPlayground\Domain\Model\Employee;

use OboPlayground\Domain\Model\Department\Department;
use OboPlayground\Domain\Model\Person\Person;

class Employee
{
    /** @var EmployeeId */
    private $id;

    /** @var Person */
    private $person;

    /** @var Department */
    private $department;

    public function __construct(EmployeeId $en_employee_id, Person $a_person, Department $a_department)
    {
        $this->id         = $en_employee_id;
        $this->person     = $a_person;
        $this->department = $a_department;
    }

    public static function register(Person $a_person, Department $a_department)
    {
        return new self(EmployeeId::uniqueId(), $a_person, $a_department);
    }

    public function employeeId()
    {
        return $this->id;
    }

    public function person()
    {
        return $this->person;
    }

    public function department()
    {
        return $this->department;
    }
}
