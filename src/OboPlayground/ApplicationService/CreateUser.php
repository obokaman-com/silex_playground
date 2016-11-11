<?php

namespace OboPlayground\ApplicationService;

use OboPlayground\DomainModel\User;
use OboPlayground\DomainModel\UserRepository;

final class CreateUser
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(CreateUserCommand $a_command)
    {
        $user1 = User::register($a_command->userId(), $a_command->email(), $a_command->name());
        $this->user_repository->persist($user1);
        $this->user_repository->flush();
    }
}
