<?php

namespace OboPlayground\Application\Service;

use OboPlayground\Domain\Model\UserRepository;

final class RemoveUser
{
    /** @var UserRepository */
    private $user_repository;

    public function __construct(UserRepository $a_user_repository)
    {
        $this->user_repository = $a_user_repository;
    }

    public function __invoke(RemoveUserCommand $a_command)
    {
        $this->user_repository->remove($a_command->userId());
        $this->user_repository->flush();
    }
}
