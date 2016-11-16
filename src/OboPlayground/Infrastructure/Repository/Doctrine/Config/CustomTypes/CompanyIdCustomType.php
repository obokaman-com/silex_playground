<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\Config\CustomTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use OboPlayground\Domain\Model\Company\CompanyId;

final class CompanyIdCustomType extends Type
{
    const COMPANY_ID = 'company_id';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "varchar(255)";
    }

    public function getName()
    {
        return self::COMPANY_ID;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new CompanyId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }
}
