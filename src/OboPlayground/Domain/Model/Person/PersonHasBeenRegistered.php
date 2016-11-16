<?php

namespace OboPlayground\Domain\Model\Person;

use OboPlayground\Domain\Kernel\DomainEvent;

final class PersonHasBeenRegistered extends DomainEvent
{
    const EVENT_KEY = 'person.registered';

    private $person_id;
    private $email;
    private $name;

    public function __construct(string $a_person_id, string $an_an_email, string $an_a_name)
    {
        parent::__construct();
        $this->person_id = $a_person_id;
        $this->email     = $an_an_email;
        $this->name      = $an_a_name;
    }
}
