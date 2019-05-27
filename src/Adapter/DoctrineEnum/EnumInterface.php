<?php declare(strict_types=1);

namespace BalticRobo\Website\Adapter\DoctrineEnum;

interface EnumInterface
{
    public static function getAvailableTypes(): array;

    public static function getFormData(): array;

    public static function getName(int $enum): string;
}
