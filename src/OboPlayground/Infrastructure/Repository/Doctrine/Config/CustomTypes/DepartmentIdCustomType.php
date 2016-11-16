<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\Config\CustomTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use OboPlayground\Domain\Model\Department\DepartmentId;

final class DepartmentIdCustomType extends Type
{
    const DEPARTMENT_ID = 'department_id';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "varchar(255)";
    }

    public function getName()
    {
        return self::DEPARTMENT_ID;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new DepartmentId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }
}
