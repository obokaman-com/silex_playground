<?php

namespace OboPlayground\DomainModel;

interface UserRepository
{
    /**
     * @param UserId $a_user_id
     *
     * @return User
     */
    public function find(UserId $a_user_id);

    /** @return User[] */
    public function findAll();

    public function persist(User $a_user);

    public function flush();
}
