<?php

namespace OboPlayground\Application\Service\Person;

use OboPlayground\Domain\Model\Person\Email;
use OboPlayground\Domain\Model\Person\PersonId;

final class EditPersonCommand
{
    private $person_id;
    private $email;
    private $name;

    public function __construct(string $an_person_id, string $an_email, string $a_name)
    {
        $this->person_id = $an_person_id;
        $this->email     = $an_email;
        $this->name      = $a_name;
    }

    public function personId()
    {
        return new PersonId($this->person_id);
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
