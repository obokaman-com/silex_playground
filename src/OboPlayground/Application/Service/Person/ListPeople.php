<?php

namespace OboPlayground\Application\Service\Person;

use OboPlayground\Domain\Model\Person\PersonRepository;

final class ListPeople
{
    /** @var PersonRepository */
    private $person_repository;

    public function __construct(PersonRepository $a_person_repository)
    {
        $this->person_repository = $a_person_repository;
    }

    public function __invoke(ListPeopleRequest $a_request)
    {
        return $this->person_repository->findByEmployedStatus($a_request->employedStatus());
    }
}
