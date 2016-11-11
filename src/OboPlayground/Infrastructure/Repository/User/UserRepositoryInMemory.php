<?php

namespace OboPlayground\Infrastructure\Repository\User;

use OboPlayground\Domain\Model\User;
use OboPlayground\Domain\Model\UserId;
use OboPlayground\Domain\Model\UserRepository;

final class UserRepositoryInMemory implements UserRepository
{
    /** @var User[] */
    private $users;

    /**
     * @param UserId $a_user_id
     *
     * @return User
     */
    public function find(UserId $a_user_id)
    {
        foreach ($this->users as $user)
        {
            if ($a_user_id->equals($user->userId()))
            {
                return $user;
            }
        }

        return null;
    }

    /** @return User[] */
    public function findAll()
    {
        return $this->users;
    }

    public function persist(User $a_user)
    {
        $this->users[] = $a_user;
    }

    public function flush()
    {
        return;
    }
}
