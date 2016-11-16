<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\Company;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use OboPlayground\Domain\Model\Company\Company;
use OboPlayground\Domain\Model\Company\CompanyId;
use OboPlayground\Domain\Model\Company\CompanyRepository as CompanyRepositoryContract;

final class CompanyRepository implements CompanyRepositoryContract
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ObjectRepository */
    private $repo;

    public function __construct(ManagerRegistry $a_manager_registry)
    {
        $this->em   = $a_manager_registry->getManagerForClass(Company::class);
        $this->repo = $this->em->getRepository(Company::class);
    }

    /**
     * @param CompanyId $an_company_id
     *
     * @return Company
     */
    public function find(CompanyId $an_company_id)
    {
        return $this->repo->find($an_company_id);
    }

    /** @return Company[] */
    public function findAll()
    {
        $company_list = [];

        $results = $this->repo->findAll();

        foreach ($results as $company)
        {
            $company_list[] = $company;
        }

        return $company_list;
    }

    public function persist(Company $an_company)
    {
        $this->em->persist($an_company);
    }

    public function remove(CompanyId $an_company_id)
    {
        $company = $this->em->getReference(Company::class, (string) $an_company_id);
        $this->em->remove($company);
    }

    public function flush()
    {
        $this->em->flush();
    }
}
