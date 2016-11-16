<?php

namespace OboPlayground\Application\Service\Person;

use OboPlayground\Domain\Model\Person\Person;
use OboPlayground\Domain\Model\Person\PersonRepository;

final class CreatePerson
{
    /** @var PersonRepository */
    private $person_repository;

    public function __construct(PersonRepository $a_person_repository)
    {
        $this->person_repository = $a_person_repository;
    }

    public function __invoke(CreatePersonCommand $a_command)
    {
        $person = Person::register($a_command->personId(), $a_command->email(), $a_command->name());

        $this->person_repository->persist($person);
        $this->person_repository->flush();
    }
}
