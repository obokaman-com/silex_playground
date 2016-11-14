<?php

namespace OboPlayground\Application\Service;

use OboPlayground\Domain\Model\Email;
use OboPlayground\Domain\Model\UserId;

final class EditUserCommand
{
    private $user_id;
    private $email;
    private $name;

    public function __construct(string $an_user_id, string $an_email, string $a_name)
    {
        $this->user_id = $an_user_id;
        $this->email   = $an_email;
        $this->name    = $a_name;
    }

    public function userId()
    {
        return new UserId($this->user_id);
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
