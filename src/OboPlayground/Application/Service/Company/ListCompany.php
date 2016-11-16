<?php

namespace OboPlayground\Application\Service\Company;

use OboPlayground\Domain\Model\Company\Company;
use OboPlayground\Domain\Model\Company\CompanyRepository;

final class ListCompany
{
    /** @var CompanyRepository */
    private $company_repository;

    public function __construct(CompanyRepository $a_company_repository)
    {
        $this->company_repository = $a_company_repository;
    }

    /** @return Company[] */
    public function __invoke()
    {
        return $this->company_repository->findAll();
    }
}
