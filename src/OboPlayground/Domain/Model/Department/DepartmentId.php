<?php

namespace OboPlayground\Domain\Model\Department;

use Ramsey\Uuid\Uuid;

final class DepartmentId
{
    /** @var string */
    private $department_id;

    public function __construct(string $a_department_id)
    {
        $this->department_id = $a_department_id;
    }

    public static function uniqueId()
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function __toString()
    {
        return $this->department_id;
    }

    public function equals(self $a_department_id)
    {
        return $this->department_id === $a_department_id->department_id;
    }
}
