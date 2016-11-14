<?php

namespace OboPlayground\Application\Service;

use OboPlayground\Domain\Model\UserNotFoundException;
use OboPlayground\Domain\Model\UserRepository;

final class EditUser
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(EditUserCommand $a_command)
    {
        $user = $this->user_repository->find($a_command->userId());

        if (empty($user))
        {
            throw new UserNotFoundException();
        }

        $user->changeName($a_command->name());
        $user->changeEmail($a_command->email());

        $this->user_repository->persist($user);
        $this->user_repository->flush();
    }
}
