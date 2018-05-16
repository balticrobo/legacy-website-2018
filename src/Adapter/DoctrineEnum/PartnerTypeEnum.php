<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\DoctrineEnum;

class PartnerTypeEnum
{
    use EnumTrait;

    public const HONORARY_PATRONAGE = 11;
    public const MEDIA_PATRONAGE = 12;
    public const SPONSOR = 20;

    private const NAMES = [
        self::HONORARY_PATRONAGE => 'enum.partner_type.honorary_patronage',
        self::MEDIA_PATRONAGE => 'enum.partner_type.media_patronage',
        self::SPONSOR => 'enum.partner_type.sponsor',
    ];

    /**
     * @return int[]
     */
    public static function getAvailableTypes(): array
    {
        return [
            self::HONORARY_PATRONAGE,
            self::MEDIA_PATRONAGE,
            self::SPONSOR,
        ];
    }
}
