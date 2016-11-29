<?php

namespace OboPlayground\Domain\Model\Company;

use Ramsey\Uuid\Uuid;

final class CompanyId
{
    /** @var string */
    private $company_id;

    public function __construct(string $a_company_id)
    {
        $this->company_id = $a_company_id;
    }

    public static function uniqueId()
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function __toString()
    {
        return $this->company_id;
    }

    public function equals(self $a_company_id)
    {
        return $this->company_id === $a_company_id->company_id;
    }
}
