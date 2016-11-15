<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\User;

use Doctrine\Common\Cache\Cache;
use OboPlayground\Domain\Model\User;
use OboPlayground\Domain\Model\UserId;
use OboPlayground\Domain\Model\UserRepository;

final class UserRepositoryFilesystem implements UserRepository
{
    /** @var User[] */
    private $users;

    /** @var Cache */
    private $cache;

    public function __construct(Cache $a_cache_system)
    {
        $this->cache = $a_cache_system;
        $this->users = $this->cache->fetch('users_list');
        if (empty($this->users))
        {
            $this->users = [];
        }
    }

    /**
     * @param UserId $a_user_id
     *
     * @return User
     */
    public function find(UserId $a_user_id)
    {
        $key = $this->contains($a_user_id);
        if (null !== $key)
        {
            return $this->users[$key];
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
        if (null === $this->contains($a_user->userId()))
        {
            $this->users[] = $a_user;
        }
    }

    public function remove(UserId $a_user_id)
    {
        $key = $this->contains($a_user_id);
        if (null !== $key)
        {
            unset($this->users[$key]);
        }
    }

    private function contains(UserId $a_user_id)
    {
        foreach ($this->users as $key => $user)
        {
            if ($a_user_id->equals($user->userId()))
            {
                return $key;
            }
        }

        return null;
    }

    public function flush()
    {
        $this->cache->save('users_list', $this->users);

        return;
    }
}
