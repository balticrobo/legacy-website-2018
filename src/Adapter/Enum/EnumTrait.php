<?php declare(strict_types=1);

namespace BalticRobo\Website\Adapter\Enum;

trait EnumTrait
{
    public static function getName(int $enum): string
    {
        if (!isset(self::NAMES[$enum])) {
            throw new UnknownEnumException((string) $enum);
        }

        return self::NAMES[$enum];
    }

    public static function getFormData(): array
    {
        return array_reduce(self::getAvailableTypes(), static function (array $carry, string $item): array {
            $carry[self::NAMES[$item]] = $item;

            return $carry;
        }, []);
    }
}
