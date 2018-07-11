<?php

namespace OboPlayground\Domain\Model\Company;

interface CompanyRepository
{
    public function find(CompanyId $a_company_id): ?Company;

    /** @return Company[] */
    public function findAll(): array;

    public function persist(Company $a_company);

    public function remove(CompanyId $a_company_id);

    public function flush();
}
