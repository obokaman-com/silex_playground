<?php

namespace OboPlayground\Application\Service;

use OboPlayground\Domain\Model\UserId;

final class RemoveUserCommand
{
    private $user_id;

    public function __construct(string $a_user_id)
    {
        $this->user_id = $a_user_id;
    }

    public function userId()
    {
        return new UserId($this->user_id);
    }
}
