<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\Company;

use Doctrine\Common\Persistence\ManagerRegistry;
use OboPlayground\Domain\Model\Company\Company;
use OboPlayground\Domain\Model\Company\CompanyId;
use OboPlayground\Infrastructure\Repository\Doctrine\InMemoryEntityManager;
use OboPlayground\Infrastructure\Repository\Doctrine\InMemoryRepository;
use PHPUnit\Framework\TestCase;

class CompanyRepositoryIntegrationTest extends TestCase
{
    /** @var CompanyRepository */
    private $company_repo;

    /** @var ManagerRegistry|\PHPUnit_Framework_MockObject_MockObject */
    private $manager_registry;

    /** @var Company */
    private $company_1, $company_2, $company_3;

    /** @var CompanyId */
    private $company_1_id, $company_2_id, $company_3_id;

    public function tearDown()
    {
        InMemoryRepository::reset();
        $this->company_repo     = null;
        $this->manager_registry = null;
        $this->company_1        = null;
        $this->company_2        = null;
        $this->company_3        = null;
        $this->company_1_id     = null;
        $this->company_2_id     = null;
        $this->company_3_id     = null;
    }

    /** @test */
    public function shouldPersistCorrectlyQuantityAndType(): void
    {
        $this->havingAManagerRegistry();
        $this->givenSomeCompanies();
        $this->whenIPersistAllOfThem();
        $this->thenRepoContentsShouldMatchQuantity(3);
        $this->andContentTypeShouldBe(Company::class);
    }

    /** @test */
    public function shouldPreventCreatingAdditionalRecordsForSameIdentity(): void
    {
        $this->havingAManagerRegistry();
        $this->givenSomeCompanies();
        $this->whenIPersistAllOfThem();
        $this->andIAddARepeatedCompany();
        $this->thenRepoContentsShouldMatchQuantity(3);
    }

    /** @test */
    public function shouldFindTheRightRecord(): void
    {
        $this->havingAManagerRegistry();
        $this->givenSomeCompanies();
        $this->whenIPersistAllOfThem();
        $this->andIRequestSomeIdIWillGetTheCorrespondingCompany($this->company_2_id, $this->company_2);
    }

    /** @test */
    public function shouldRemoveARecordFromStorage(): void
    {
        $this->havingAManagerRegistry();
        $this->givenSomeCompanies();
        $this->whenIPersistAllOfThem();
        $this->andIRemoveACompany($this->company_2_id);
        $this->thenRepoContentsShouldMatchQuantity(2);
        $this->andIShouldNotBeAbleToFindCompany($this->company_2_id);
    }

    private function havingAManagerRegistry(): void
    {
        $entity_manager         = new InMemoryEntityManager();
        $this->manager_registry = $this->getMockBuilder(ManagerRegistry::class)->getMock();
        $this->manager_registry->method('getManagerForClass')->willReturn($entity_manager);
    }

    private function givenSomeCompanies(): void
    {
        $this->company_1_id = CompanyId::uniqueId();
        $this->company_2_id = CompanyId::uniqueId();
        $this->company_3_id = CompanyId::uniqueId();

        $this->company_1 = Company::create($this->company_1_id, 'Mi compañía 1');
        $this->company_2 = Company::create($this->company_2_id, 'Mi compañía 2');
        $this->company_3 = Company::create($this->company_3_id, 'Mi compañía 3');
    }

    private function whenIPersistAllOfThem(): void
    {
        $this->company_repo = new CompanyRepository($this->manager_registry);
        $this->company_repo->persist($this->company_1);
        $this->company_repo->persist($this->company_2);
        $this->company_repo->persist($this->company_3);
        $this->company_repo->flush();
    }

    private function thenRepoContentsShouldMatchQuantity(int $quantity): void
    {
        $this->assertCount($quantity, $this->company_repo->findAll());
    }

    private function andIAddARepeatedCompany(): void
    {
        $this->company_repo->persist($this->company_3);
        $this->company_repo->persist($this->company_3);
        $this->company_repo->flush();
    }

    private function andContentTypeShouldBe(string $class_name): void
    {
        $this->assertContainsOnly($class_name, $this->company_repo->findAll());
    }

    private function andIRequestSomeIdIWillGetTheCorrespondingCompany(CompanyId $a_company_id, Company $a_company): void
    {
        $this->assertEquals($a_company, $this->company_repo->find($a_company_id));
    }

    private function andIRemoveACompany(CompanyId $a_company_id): void
    {
        $this->company_repo->remove($a_company_id);
        $this->company_repo->flush();
    }

    private function andIShouldNotBeAbleToFindCompany(CompanyId $a_company_id): void
    {
        $this->assertNull($this->company_repo->find($a_company_id));
    }
}
