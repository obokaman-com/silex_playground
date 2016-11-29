<?php

namespace OboPlayground\Domain\Model\Company;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use OboPlayground\Domain\Kernel\EventRecorder;
use OboPlayground\Domain\Model\Department\Department;
use OboPlayground\Domain\Model\Department\DepartmentId;
use OboPlayground\Domain\Model\Employee\Employee;
use OboPlayground\Domain\Model\Employee\EmployeeHasBeenFired;
use OboPlayground\Domain\Model\Employee\EmployeeHasBeenHired;
use OboPlayground\Domain\Model\Person\Person;

class Company
{
    /** @var CompanyId */
    private $id;

    /** @var string */
    private $name;

    /** @var ArrayCollection */
    private $departments;

    /** @var ArrayCollection */
    private $employees;

    public function __construct(CompanyId $a_company_id, $a_name, array $a_departments_list, array $an_employees_list)
    {
        $this->id          = $a_company_id;
        $this->name        = $a_name;
        $this->departments = new ArrayCollection($a_departments_list);
        $this->employees   = new ArrayCollection($an_employees_list);
    }

    public static function create(CompanyId $a_company_id, $a_name)
    {
        return new self($a_company_id, $a_name, [], []);
    }

    public function companyId()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    /** @return Department[] */
    public function departments()
    {
        return $this->departments->toArray();
    }

    /** @return Employee[] */
    public function employees()
    {
        return $this->employees->toArray();
    }

    public function changeName(string $a_new_name)
    {
        if ($a_new_name == $this->name)
        {
            return;
        }

        $this->name = $a_new_name;
    }

    public function addDepartment($a_department_name)
    {
        if (null === $this->findDepartmentByName($a_department_name))
        {
            $new_department = new Department(DepartmentId::uniqueId(), $a_department_name);
            $this->departments->add($new_department);
        }
    }

    public function removeDepartment($a_department_name)
    {
        if ($department_to_remove = $this->findDepartmentByName($a_department_name))
        {
            $this->departments->removeElement($department_to_remove);
        }
    }

    public function hire(Person $a_new_employee, $a_department_name)
    {
        $department = $this->findDepartmentByName($a_department_name);
        if (empty($department))
        {
            throw new \InvalidArgumentException(
                'Department ' . $a_department_name . ' does not exists at ' . $this->name . '. Current departments: '
                . var_export($this->departments->toArray(), true)
            );
        }

        if ($this->findEmployeeByPerson($a_new_employee))
        {
            throw new \InvalidArgumentException($a_new_employee->name() . ' was already hired by ' . $this->name . '.');
        }

        $employee = Employee::register($a_new_employee, $department);
        $this->employees->add($employee);

        EventRecorder::instance()->recordEvent(
            new EmployeeHasBeenHired($this->companyId(), $department->departmentId(), $employee->employeeId())
        );
    }

    public function fire(Person $a_person)
    {
        $employee = $this->findEmployeeByPerson($a_person);
        if (empty($employee))
        {
            throw new \InvalidArgumentException($a_person->name() . ' was never hired by ' . $this->name . '.');
        }

        $this->employees->removeElement($employee);

        EventRecorder::instance()->recordEvent(new EmployeeHasBeenFired($this->companyId(), $employee->employeeId()));
    }

    /** @return Department */
    private function findDepartmentByName($a_department_name)
    {
        $department = $this->departments->matching(
            Criteria::create()
                ->where(Criteria::expr()->eq('name', $a_department_name))
                ->setFirstResult(0)
                ->setMaxResults(1)
        )->first();

        if (empty($department))
        {
            return null;
        }

        return $department;
    }

    /** @return Employee */
    private function findEmployeeByPerson(Person $a_person)
    {
        $employee = $this->employees->matching(
            Criteria::create()
                ->where(Criteria::expr()->eq('person_id', $a_person->personId()))
                ->setFirstResult(0)
                ->setMaxResults(1)
        )->first();

        if (empty($employee))
        {
            return null;
        }

        return $employee;
    }
}
