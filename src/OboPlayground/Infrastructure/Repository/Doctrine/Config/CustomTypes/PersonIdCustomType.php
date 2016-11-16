<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\Config\CustomTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use OboPlayground\Domain\Model\Person\PersonId;

final class PersonIdCustomType extends Type
{
    const PERSON_ID = 'person_id';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "varchar(255)";
    }

    public function getName()
    {
        return self::PERSON_ID;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new PersonId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }
}
