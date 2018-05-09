<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\DoctrineEnum;

class InformationTypeEnum
{
    public const INFO = 0;
    public const HOTEL = 1;

    private const NAMES = [
        self::INFO => 'enm.information_type.info',
        self::HOTEL => 'enum.information_type.hotel',
    ];
    private const FONT_AWESOME = [
        self::INFO => 'fa-info-circle',
        self::HOTEL => 'fa-home',
    ];

    public static function getName(int $enum): string
    {
        if (!isset(self::NAMES[$enum])) {
            throw new UnknownEnumException((string) $enum);
        }

        return self::NAMES[$enum];
    }

    public static function getFontAwesomeName(int $enum): string
    {
        if (!isset(self::FONT_AWESOME[$enum])) {
            throw new UnknownEnumException((string) $enum);
        }

        return 'fa fa-fw '.self::FONT_AWESOME[$enum];
    }

    /**
     * @return int[]
     */
    public static function getAvailableTypes(): array
    {
        return [
            self::HOTEL,
        ];
    }

    public static function getFormData(): array
    {
        return array_reduce(self::getAvailableTypes(), function (array $carry, string $item) {
            $carry[self::NAMES[$item]] = $item;

            return $carry;
        }, []);
    }
}
