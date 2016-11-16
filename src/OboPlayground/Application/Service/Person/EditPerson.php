<?php

namespace OboPlayground\Application\Service\Person;

use OboPlayground\Domain\Model\Person\PersonRepository;

final class EditPerson
{
    /** @var PersonRepository */
    private $person_repository;

    public function __construct(PersonRepository $a_person_repository)
    {
        $this->person_repository = $a_person_repository;
    }

    public function __invoke(EditPersonCommand $a_command)
    {
        $person = $this->person_repository->find($a_command->personId());

        $person->changeName($a_command->name());
        $person->changeEmail($a_command->email());

        $this->person_repository->persist($person);
        $this->person_repository->flush();
    }
}
