<?php

namespace OboPlayground\Application\Service\Person;

use OboPlayground\Domain\Model\Person\PersonId;

final class RemovePersonCommand
{
    private $person_id;

    public function __construct(string $a_person_id)
    {
        $this->person_id = $a_person_id;
    }

    public function personId()
    {
        return new PersonId($this->person_id);
    }
}
