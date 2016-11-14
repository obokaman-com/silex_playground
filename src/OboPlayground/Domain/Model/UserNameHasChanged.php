<?php

namespace OboPlayground\Domain\Model;

use OboPlayground\Domain\Kernel\DomainEvent;

final class UserNameHasChanged extends DomainEvent
{
    const EVENT_KEY = 'user.changed.name';

    /** @var string */
    private $user_id;

    /** @var string */
    private $name;

    public function __construct(string $an_user_id, string $a_name)
    {
        parent::__construct();

        $this->user_id = $an_user_id;
        $this->name    = $a_name;
    }
}
