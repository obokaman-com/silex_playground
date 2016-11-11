<?php

namespace OboPlayground\Domain\Model;

use Ramsey\Uuid\Uuid;

final class UserId
{
    /** @var string */
    private $user_id;

    public function __construct(string $a_user_id)
    {
        $this->user_id = $a_user_id;
    }

    public static function uniqueId()
    {
        return new self(Uuid::uuid4());
    }

    public function __toString()
    {
        return $this->user_id;
    }

    public function equals(UserId $userId)
    {
        return $this->user_id === $userId->user_id;
    }
}
