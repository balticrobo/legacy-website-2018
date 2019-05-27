<?php declare(strict_types=1);

namespace BalticRobo\Website\Adapter\DoctrineEnum;

final class UnknownEnumException extends \DomainException
{
    public function __construct(string $enum)
    {
        parent::__construct("Unknown enum key: {$enum}.");
    }
}
