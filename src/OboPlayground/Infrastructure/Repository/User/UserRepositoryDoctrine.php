<?php

namespace OboPlayground\Infrastructure\Repository\User;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use OboPlayground\Domain\Model\User;
use OboPlayground\Domain\Model\UserId;
use OboPlayground\Domain\Model\UserRepository;

final class UserRepositoryDoctrine implements UserRepository
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ObjectRepository */
    private $repo;

    public function __construct(EntityManagerInterface $an_entity_manager)
    {
        $this->em   = $an_entity_manager;
        $this->repo = $this->em->getRepository(User::class);
    }

    /**
     * @param UserId $a_user_id
     *
     * @return User
     */
    public function find(UserId $a_user_id)
    {
        return $this->repo->find($a_user_id);
    }

    /** @return User[] */
    public function findAll()
    {
        $users_list = [];

        $results = $this->repo->findAll();

        foreach ($results as $user)
        {
            $users_list[] = $user;
        }

        return $users_list;
    }

    public function persist(User $a_user)
    {
        $this->em->persist($a_user);
    }

    public function remove(UserId $a_user_id)
    {
        $user = $this->em->getReference(User::class, (string) $a_user_id);
        $this->em->remove($user);
    }

    public function flush()
    {
        $this->em->flush();
    }
}
