<?php

namespace OboPlayground\Domain\Model\Person;

use OboPlayground\Domain\Kernel\EventRecorder;

class Person
{
    /** @var PersonId */
    private $id;

    /** @var Email */
    private $email;

    /** @var string */
    private $name;

    public function __construct(PersonId $a_person_id, Email $an_email, $a_name)
    {
        $this->id    = $a_person_id;
        $this->email = $an_email;
        $this->name  = $a_name;
    }

    public static function register(PersonId $a_person_id, Email $an_email, string $a_name)
    {
        EventRecorder::instance()->recordEvent(new PersonHasBeenRegistered($a_person_id, $an_email, $a_name));

        return new self($a_person_id, $an_email, $a_name);
    }

    public function personId()
    {
        return $this->id;
    }

    public function email()
    {
        return $this->email;
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

        EventRecorder::instance()->recordEvent(new PersonNameHasChanged($this->id, $this->name));
    }

    public function changeEmail(Email $a_new_email)
    {
        if ($this->email->equals($a_new_email))
        {
            return;
        }

        $this->email = $a_new_email;

        EventRecorder::instance()->recordEvent(new PersonEmailHasChanged($this->id, $this->email));
    }
}
