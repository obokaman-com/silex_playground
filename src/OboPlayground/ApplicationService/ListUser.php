<?php

namespace OboPlayground\ApplicationService;

use OboPlayground\DomainModel\User;
use OboPlayground\DomainModel\UserRepository;

final class ListUser
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    /** @return User[] */
    public function __invoke()
    {
        return $this->user_repository->findAll();
    }
}
