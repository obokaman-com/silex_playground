<?php

namespace OboPlayground\Application\Service\Company;

use OboPlayground\Domain\Model\Company\CompanyRepository;
use OboPlayground\Domain\Model\Employee\EmployedStatus;
use OboPlayground\Domain\Model\Person\PersonRepository;

final class HireRandomEmployee
{
    /** @var CompanyRepository */
    private $company_repository;

    /** @var PersonRepository */
    private $person_repository;

    public function __construct(CompanyRepository $a_company_repository, PersonRepository $an_person_repository)
    {
        $this->company_repository = $a_company_repository;
        $this->person_repository  = $an_person_repository;
    }

    public function __invoke(HireRandomEmployeeCommand $a_command)
    {
        $available_companies = $this->company_repository->findAll();

        if (empty($available_companies))
        {
            throw new \DomainException('Not available companies!');
        }

        $random_company        = $available_companies[rand(0, count($available_companies) - 1)];
        $available_departments = $random_company->departments();
        $random_department     = $available_departments[rand(0, count($available_departments) - 1)];
        $employable_people     = $this->person_repository->findByEmployedStatus(EmployedStatus::UNEMPLOYED());

        if (empty($employable_people))
        {
            throw new \DomainException('Not available people to hire!');
        }

        $random_employable_person = $employable_people[rand(0, count($employable_people) - 1)];

        $random_company->hire($random_employable_person, $random_department->name());

        $this->company_repository->persist($random_company);
        $this->company_repository->flush();
    }
}
