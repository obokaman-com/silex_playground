<?php

namespace OboPlayground\ApplicationService;

use OboPlayground\DomainModel\Email;
use OboPlayground\DomainModel\UserId;

final class CreateUserCommand
{
    private $user_id;
    private $email;
    private $name;

    public function __construct($an_email, $a_name)
    {
        $this->user_id = UserId::uniqueId();
        $this->email   = $an_email;
        $this->name    = $a_name;
    }

    public function userId()
    {
        return $this->user_id;
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
