<?php

namespace OboPlayground\Application\Service\Person;

use OboPlayground\Domain\Model\Person\Email;
use OboPlayground\Domain\Model\Person\PersonId;

final class CreatePersonCommand
{
    private $person_id;
    private $email;
    private $name;

    public function __construct(string $an_email, string $a_name)
    {
        $this->person_id = PersonId::uniqueId();
        $this->email     = $an_email;
        $this->name      = $a_name;
    }

    public function personId()
    {
        return $this->person_id;
    }

    public function email()
    {
        return new Email($this->email);
    }

    public function name()
    {
        return $this->name;
    }
}
