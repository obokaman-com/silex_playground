<?php

namespace OboPlayground\Domain\Model;

use OboPlayground\Domain\Kernel\EventRecorder;

class User
{
    /** @var UserId */
    private $user_id;

    /** @var Email */
    private $email;

    /** @var string */
    private $name;

    public function __construct(UserId $an_user_id, Email $an_email, $a_name)
    {
        $this->user_id = $an_user_id;
        $this->email   = $an_email;
        $this->name    = $a_name;
    }

    public static function register(UserId $a_user_id, Email $an_email, string $a_name)
    {
        EventRecorder::instance()->recordEvent(new UserHasBeenRegistered($a_user_id, $an_email, $a_name));

        return new self($a_user_id, $an_email, $a_name);
    }

    public function userId()
    {
        return $this->user_id;
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

        EventRecorder::instance()->recordEvent(new UserNameHasChanged($this->user_id, $a_new_name));
    }

    public function changeEmail(Email $a_new_email)
    {
        if ($this->email->equals($a_new_email))
        {
            return;
        }

        $this->email = $a_new_email;

        EventRecorder::instance()->recordEvent(new UserEmailHasChanged($this->user_id, $a_new_email));
    }
}
