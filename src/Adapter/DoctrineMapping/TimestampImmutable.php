<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\DoctrineMapping;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class TimestampImmutable extends Type
{
    private const DOCTRINE_REPRESENTATION = 'timestamp_immutable';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?\DateTimeImmutable
    {
        if ($value === null || $value instanceof \DateTimeImmutable) {
            return $value;
        }

        return new \DateTimeImmutable("@{$value}");
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value === null) {
            return $value;
        }

        return $value->getTimestamp();
    }

    public function getName()
    {
        return self::DOCTRINE_REPRESENTATION;
    }
}
