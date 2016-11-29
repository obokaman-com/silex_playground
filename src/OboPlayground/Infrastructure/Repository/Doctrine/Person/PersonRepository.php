<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\Person;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use OboPlayground\Domain\Model\Employee\EmployedStatus;
use OboPlayground\Domain\Model\Person\Person;
use OboPlayground\Domain\Model\Person\PersonId;
use OboPlayground\Domain\Model\Person\PersonRepository as PersonRepositoryContract;

final class PersonRepository implements PersonRepositoryContract
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ObjectRepository */
    private $repo;

    public function __construct(ManagerRegistry $a_manager_registry)
    {
        $this->em   = $a_manager_registry->getManagerForClass(Person::class);
        $this->repo = $this->em->getRepository(Person::class);
    }

    public function find(PersonId $an_person_id)
    {
        return $this->repo->find($an_person_id);
    }

    public function findAll()
    {
        return $this->hydrateItemsList($this->repo->findAll());
    }

    public function findByEmployedStatus(EmployedStatus $employedStatus)
    {
        $query = $this->findByEmployedStatusDql($employedStatus);

        $results = $this->em->createQuery($query)->getResult();

        return $this->hydrateItemsList($results);
    }

    /**
     * @param array $results
     *
     * @return Person[]
     */
    private function hydrateItemsList(array $results)
    {
        $people = [];

        foreach ($results as $person)
        {
            $people[] = $person;
        }

        return $people;
    }


    public function persist(Person $a_person)
    {
        $this->em->persist($a_person);
    }

    public function remove(PersonId $a_person_id)
    {
        $person = $this->repo->find($a_person_id);
        $this->em->remove($person);
    }

    public function flush()
    {
        $this->em->flush();
    }

    private function findByEmployedStatusDql(EmployedStatus $employedStatus):string
    {
        if ($employedStatus->isEmployed())
        {
            return <<<DQL
SELECT 
    p 
FROM
    OboPlayground\Domain\Model\Person\Person p
WHERE p.id IN
( 
    SELECT 
        p2.id
    FROM 
        OboPlayground\Domain\Model\Employee\Employee e
            JOIN e.person p2
)
DQL;
        }

        return <<<DQL
SELECT 
    p 
FROM
    OboPlayground\Domain\Model\Person\Person p
WHERE p.id NOT IN
( 
    SELECT 
        p2.id
    FROM 
        OboPlayground\Domain\Model\Employee\Employee e
            JOIN e.person p2
)
DQL;
    }
}
