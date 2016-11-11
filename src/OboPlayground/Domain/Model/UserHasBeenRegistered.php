<?php

namespace OboPlayground\Domain\Model;

use OboPlayground\Domain\Kernel\DomainEvent;

class UserHasBeenRegistered extends DomainEvent
{
    const EVENT_KEY = 'user.created';

    /** @var string */
    private $user_id;

    /** @var string */
    private $email;

    /** @var string */
    private $name;

    public function __construct(string $a_user_id, string $a_email, string $a_name)
    {
        parent::__construct();

        $this->user_id = $a_user_id;
        $this->email   = $a_email;
        $this->name    = $a_name;
    }
}
