<?php

namespace OboPlayground\Application\Service\Company;

use OboPlayground\Domain\Model\Company\CompanyId;

final class CreateCompanyCommand
{
    private $company_id;
    private $name;

    public function __construct(string $a_name)
    {
        $this->company_id = CompanyId::uniqueId();
        $this->name       = $a_name;
    }

    public function companyId()
    {
        return $this->company_id;
    }

    public function name()
    {
        return $this->name;
    }
}
