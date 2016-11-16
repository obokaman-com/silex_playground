<?php

namespace OboPlayground\Domain\Model\Company;

interface CompanyRepository
{
    /**
     * @param CompanyId $a_company_id
     *
     * @return Company
     */
    public function find(CompanyId $a_company_id);

    /** @return Company[] */
    public function findAll();

    public function persist(Company $a_company);

    public function remove(CompanyId $a_company_id);

    public function flush();
}
