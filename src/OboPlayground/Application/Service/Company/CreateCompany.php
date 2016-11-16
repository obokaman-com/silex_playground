<?php

namespace OboPlayground\Application\Service\Company;

use OboPlayground\Domain\Model\Company\Company;
use OboPlayground\Domain\Model\Company\CompanyRepository;

final class CreateCompany
{
    const AVAILABLE_RANDOM_DEPARTMENTS = [
        'Business',
        'Marketing',
        'Contents',
        'Technical',
        'Customer Service',
        'Financial',
        'Direction'
    ];
    /** @var CompanyRepository */
    private $company_repository;

    public function __construct(CompanyRepository $a_company_repository)
    {
        $this->company_repository = $a_company_repository;
    }

    public function __invoke(CreateCompanyCommand $a_command)
    {
        $company = Company::create($a_command->companyId(), $a_command->name());

        $this->addRandomDepartments($company, 3);

        $this->company_repository->persist($company);
        $this->company_repository->flush();
    }

    private function addRandomDepartments(Company $company, $quantity)
    {
        $random_departments = array_rand(self::AVAILABLE_RANDOM_DEPARTMENTS, $quantity);
        foreach ($random_departments as $random_department)
        {
            $company->addDepartment(self::AVAILABLE_RANDOM_DEPARTMENTS[$random_department]);
        }
    }
}
