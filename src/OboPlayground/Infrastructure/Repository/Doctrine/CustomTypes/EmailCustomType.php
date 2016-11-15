<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine\CustomTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use OboPlayground\Domain\Model\Email;

final class EmailCustomType extends Type
{
    const EMAIL = 'email';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "string(255)";
    }

    public function getName()
    {
        return self::EMAIL;
    }
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Email($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }
}
