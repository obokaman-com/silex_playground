<?php

namespace OboPlayground\Domain\Model;

use OboPlayground\Domain\Kernel\DomainEvent;

final class UserEmailHasChanged extends DomainEvent
{
    const EVENT_KEY = 'user.changed.email';

    /** @var string */
    private $user_id;

    /** @var string */
    private $email;

    public function __construct(string $an_user_id, string $an_email)
    {
        parent::__construct();

        $this->user_id = $an_user_id;
        $this->email   = $an_email;
    }
}
