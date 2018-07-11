<?php

namespace OboPlayground\Domain\Model\Department;

class Department
{
    /** @var DepartmentId */
    private $id;

    /** @var string */
    private $name;

    public function __construct(DepartmentId $a_department_id, $a_name)
    {
        $this->id   = $a_department_id;
        $this->name = $a_name;
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function changeName(string $a_new_name)
    {
        if ($a_new_name == $this->name)
        {
            return;
        }

        $this->name = $a_new_name;
    }

    /**
     * Why? https://github.com/doctrine/collections/pull/95
     */
    public function __get($name)
    {
        if (property_exists($this, $name))
        {
            return $this->$name;
        }
    }
}
