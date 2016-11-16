<?php

namespace OboPlayground\Application\Service\Company;

use OboPlayground\Domain\Model\Company\CompanyId;

final class RemoveCompanyCommand
{
    private $company_id;

    public function __construct(string $a_company_id)
    {
        $this->company_id = $a_company_id;
    }

    public function companyId()
    {
        return new CompanyId($this->company_id);
    }
}
