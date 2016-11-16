<?php

namespace OboPlayground\Domain\Model\Person;

use OboPlayground\Domain\Kernel\DomainEvent;

final class PersonNameHasChanged extends DomainEvent
{
    const EVENT_KEY = 'person.changed.name';

    private $person_id;
    private $name;

    public function __construct(string $a_person_id, string $a_name)
    {
        parent::__construct();

        $this->person_id = $a_person_id;
        $this->name      = $a_name;
    }
}
