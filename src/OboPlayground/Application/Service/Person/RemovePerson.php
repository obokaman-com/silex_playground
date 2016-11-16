<?php

namespace OboPlayground\Application\Service\Person;

use OboPlayground\Domain\Model\Person\PersonRepository;

final class RemovePerson
{
    /** @var PersonRepository */
    private $person_repository;

    public function __construct(PersonRepository $a_person_repository)
    {
        $this->person_repository = $a_person_repository;
    }

    public function __invoke(RemovePersonCommand $a_command)
    {
        $this->person_repository->remove($a_command->personId());
        $this->person_repository->flush();
    }
}
