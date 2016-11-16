<?php

namespace OboPlayground\Application\Service\Company;

use OboPlayground\Domain\Model\Company\CompanyRepository;

final class RemoveCompany
{
    /** @var CompanyRepository */
    private $company_repository;

    public function __construct(CompanyRepository $a_company_repository)
    {
        $this->company_repository = $a_company_repository;
    }

    public function __invoke(RemoveCompanyCommand $a_command)
    {
        $this->company_repository->remove($a_command->companyId());
        $this->company_repository->flush();
    }
}
