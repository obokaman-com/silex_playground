<?php

namespace OboPlayground\Application\Service\Company;

use Doctrine\Common\Persistence\ManagerRegistry;
use OboPlayground\Domain\Model\Company\Company;
use OboPlayground\Domain\Model\Company\CompanyId;
use OboPlayground\Infrastructure\Repository\Doctrine\Company\CompanyRepository;
use OboPlayground\Infrastructure\Repository\Doctrine\InMemoryEntityManager;
use OboPlayground\Infrastructure\Repository\Doctrine\InMemoryRepository;
use PHPUnit\Framework\TestCase;

class CreateCompanyIntegrationTest extends TestCase
{
    /** @var CompanyRepository */
    private $company_repo;

    /** @var CreateCompanyCommand */
    private $command;

    /** @var CompanyId */
    private $company_id;

    /** @var string */
    private $company_name;

    public function tearDown()
    {
        InMemoryRepository::reset();
        $this->company_repo = null;
        $this->command      = null;
        $this->company_id   = null;
        $this->company_name = null;
    }

    /** @test */
    public function shouldCreateAndPersistACompany(): void
    {
        $this->givenANewCompany();
        $this->havingACompanyRepository();
        $this->whenICreateACompany();
        $this->thenGivenCompanyShouldHaveBeenPersisted();
    }

    private function givenANewCompany(): void
    {
        $this->command      = new CreateCompanyCommand('My company 1');
        $this->company_id   = $this->command->companyId();
        $this->company_name = $this->command->name();
    }

    private function havingACompanyRepository(): void
    {
        $entity_manager = new InMemoryEntityManager();
        /** @var ManagerRegistry|\PHPUnit_Framework_MockObject_MockObject $manager_registry */
        $manager_registry = $this->getMockBuilder(ManagerRegistry::class)->getMock();
        $manager_registry->method('getManagerForClass')->willReturn($entity_manager);
        $this->company_repo = new CompanyRepository($manager_registry);
    }

    private function whenICreateACompany(): void
    {
        $create_company = new CreateCompany($this->company_repo);
        $create_company->__invoke($this->command);
    }

    private function thenGivenCompanyShouldHaveBeenPersisted(): void
    {
        $company = $this->company_repo->find($this->company_id);
        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals($this->company_id, $company->id());
        $this->assertEquals($this->company_name, $company->name());
    }
}
