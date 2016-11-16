<?php

namespace OboPlayground\Domain\Model\Person;

use OboPlayground\Domain\Kernel\DomainEvent;

final class PersonEmailHasChanged extends DomainEvent
{
    const EVENT_KEY = 'person.changed.email';

    private $person_id;
    private $email;

    public function __construct(string $a_person_id, string $an_email)
    {
        parent::__construct();

        $this->person_id = $a_person_id;
        $this->email     = $an_email;
    }
}
