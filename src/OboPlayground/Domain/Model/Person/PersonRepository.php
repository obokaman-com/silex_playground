<?php

namespace OboPlayground\Domain\Model\Person;

use OboPlayground\Domain\Model\Employee\EmployedStatus;

interface PersonRepository
{
    /**
     * @param PersonId $a_person_id
     *
     * @return Person
     */
    public function find(PersonId $a_person_id);

    /** @return Person[] */
    public function findAll();

    /**
     * @param EmployedStatus $employedStatus
     *
     * @return Person[]
     */
    public function findByEmployedStatus(EmployedStatus $employedStatus);

    public function persist(Person $a_person);

    public function remove(PersonId $a_person_id);

    public function flush();
}
