<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\CustomTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use OboPlayground\Domain\Model\UserId;

final class UserIdCustomType extends Type
{
    const USER_ID = 'user_id';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "string(255)";
    }

    public function getName()
    {
        return self::USER_ID;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new UserId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }
}
