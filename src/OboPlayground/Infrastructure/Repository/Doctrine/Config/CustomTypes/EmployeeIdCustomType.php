<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\Config\CustomTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use OboPlayground\Domain\Model\Employee\EmployeeId;

final class EmployeeIdCustomType extends Type
{
    const EMPLOYEE_ID = 'employee_id';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "varchar(255)";
    }

    public function getName()
    {
        return self::EMPLOYEE_ID;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new EmployeeId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }
}
