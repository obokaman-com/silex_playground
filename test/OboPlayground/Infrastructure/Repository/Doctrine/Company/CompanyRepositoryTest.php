<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\Company;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use OboPlayground\Domain\Model\Company\Company;
use OboPlayground\Domain\Model\Company\CompanyId;
use PHPUnit\Framework\TestCase;

class CompanyRepositoryTest extends TestCase
{
    /** @var Company */
    private $company;

    /** @var CompanyId */
    private $company_id;

    /** @var ManagerRegistry|\PHPUnit_Framework_MockObject_MockObject */
    private $manager_registry;

    /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $entity_manager;

    /** @var ObjectRepository|\PHPUnit_Framework_MockObject_MockObject */
    private $repository;

    /** @var CompanyRepository */
    private $company_repository;

    /** @var mixed */
    private $results;

    /** @var Company[] */
    private $companies_list;

    public function tearDown()
    {
        $this->company            = null;
        $this->company_id         = null;
        $this->companies_list     = null;
        $this->repository         = null;
        $this->entity_manager     = null;
        $this->manager_registry   = null;
        $this->company_repository = null;
        $this->results            = null;
    }

    /**
     * @test
     * @dataProvider companiesDataProvider
     *
     * @param Company $a_company
     */
    public function shouldPersistACompany(Company $a_company): void
    {
        $this->givenACompany($a_company);
        $this->havingAnEntityManager();
        $this->thenIShouldCallEntityManagerPersist();
        $this->whenIPersistACompany();
    }

    /**
     * @test
     * @dataProvider companyIdsDataProvider
     *
     * @param CompanyId $a_company_id
     */
    public function shouldFindACompany(CompanyId $a_company_id): void
    {
        $this->givenACompanyId($a_company_id);
        $this->havingAnEntityManager();
        $this->thenIShouldCallRepositoryFind();
        $this->whenITryToFindACompany();
        $this->andFoundCompanyShouldMatchWhatRepositoryReturned();
    }

    /** @test */
    public function shouldListCompanies(): void
    {
        $this->havingAnEntityManager();
        $this->thenIShouldCallRepositoryFindAll();
        $this->whenITryToFindAllCompanies();
        $this->andFoundCompaniesShouldMatchWhatRepositoryReturned();
    }

    /**
     * @test
     * @dataProvider companyIdsDataProvider
     *
     * @param CompanyId $a_company_id
     */
    public function shouldRemoveACompany(CompanyId $a_company_id): void
    {
        $this->givenACompanyId($a_company_id);
        $this->havingAnEntityManager();
        $this->thenIShouldCallEntityManagerRemove();
        $this->whenITryToRemoveACompany();
    }

    private function givenACompany(Company $a_company): void
    {
        $this->company = $a_company;
    }

    private function havingAnEntityManager(): void
    {
        $this->repository       = $this->getMockBuilder(ObjectRepository::class)->getMock();
        $this->entity_manager   = $this->getMockBuilder(EntityManagerInterface::class)->getMock();
        $this->manager_registry = $this->getMockBuilder(ManagerRegistry::class)->getMock();
        $this->manager_registry
            ->expects($this->once())
            ->method('getManagerForClass')
            ->with(Company::class)
            ->willReturn($this->entity_manager);
        $this->entity_manager
            ->expects($this->once())
            ->method('getRepository')
            ->with(Company::class)
            ->willReturn($this->repository);
    }

    private function thenIShouldCallEntityManagerPersist(): void
    {
        $this->entity_manager->expects($this->once())->method('persist')->with($this->company);
    }

    private function whenIPersistACompany(): void
    {
        $this->company_repository = new CompanyRepository($this->manager_registry);
        $this->company_repository->persist($this->company);
    }

    private function givenACompanyId(CompanyId $a_company_id): void
    {
        $this->company_id = $a_company_id;
    }

    private function thenIShouldCallRepositoryFind(): void
    {
        $this->company = $this->companiesList()[0];
        $this->repository->expects($this->once())->method('find')->with($this->company_id)->willReturn($this->company);
    }

    private function whenITryToFindACompany(): void
    {
        $this->company_repository = new CompanyRepository($this->manager_registry);
        $this->results            = $this->company_repository->find($this->company_id);
    }

    private function thenIShouldCallRepositoryFindAll(): void
    {
        $this->companies_list = $this->companiesList();
        $this->repository->expects($this->once())->method('findAll')->willReturn($this->companies_list);
    }

    private function whenITryToFindAllCompanies(): void
    {
        $this->company_repository = new CompanyRepository($this->manager_registry);
        $this->results            = $this->company_repository->findAll();
    }

    private function thenIShouldCallEntityManagerRemove(): void
    {
        $company = $this->companiesList()[0];
        $this->entity_manager
            ->expects($this->once())->method('getReference')
            ->with(Company::class, (string) $this->company_id)
            ->willReturn($company);
        $this->entity_manager->expects($this->once())->method('remove')->with($company);
    }

    private function whenITryToRemoveACompany(): void
    {
        $this->company_repository = new CompanyRepository($this->manager_registry);
        $this->company_repository->remove($this->company_id);
    }

    public function companiesDataProvider(): array
    {
        $companies_list = $this->companiesList();

        return [
            [$companies_list[0]],
            [$companies_list[1]],
            [$companies_list[2]]
        ];
    }

    public function companyIdsDataProvider(): array
    {
        $company_ids = $this->companyIdsList();

        return [
            [$company_ids[0]],
            [$company_ids[1]],
            [$company_ids[2]]
        ];
    }

    private function companiesList(): array
    {
        $company_ids = $this->companyIdsList();

        return [
            Company::create($company_ids[0], 'Company 1'),
            Company::create($company_ids[1], 'Company 2'),
            Company::create($company_ids[2], 'Company 3')
        ];
    }

    private function companyIdsList(): array
    {
        return [
            CompanyId::uniqueId(),
            CompanyId::uniqueId(),
            CompanyId::uniqueId()
        ];
    }

    private function andFoundCompanyShouldMatchWhatRepositoryReturned(): void
    {
        $this->assertEquals($this->company, $this->results);
    }

    private function andFoundCompaniesShouldMatchWhatRepositoryReturned(): void
    {
        $this->assertEquals($this->companies_list, $this->results);
    }
}
