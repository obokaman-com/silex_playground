<?php

namespace OboPlayground\Infrastructure\Repository\User;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use OboPlayground\DomainModel\User;
use OboPlayground\DomainModel\UserId;
use OboPlayground\DomainModel\UserRepository;

final class UserRepositoryDoctrine implements UserRepository
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ObjectRepository */
    private $repo;

    public function __construct(EntityManagerInterface $an_entity_manager)
    {
        $this->em = $an_entity_manager;
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
        return $this->repo->findAll();
    }

    public function persist(User $a_user)
    {
        $this->em->persist($a_user);
    }

    public function flush()
    {
        $this->em->flush();
    }
}
