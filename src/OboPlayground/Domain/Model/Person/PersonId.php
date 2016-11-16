<?php

namespace OboPlayground\Domain\Model\Person;

use Ramsey\Uuid\Uuid;

final class PersonId
{
    /** @var string */
    private $person_id;

    public function __construct(string $a_person_id)
    {
        $this->person_id = $a_person_id;
    }

    public static function uniqueId()
    {
        return new self(Uuid::uuid4());
    }

    public function __toString()
    {
        return $this->person_id;
    }

    public function equals(self $a_person_id)
    {
        return $this->person_id === $a_person_id->person_id;
    }
}
