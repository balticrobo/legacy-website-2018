<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\DoctrineEnum;

class ShirtTypeEnum
{
    use EnumTrait;

    public const NONE = 0;
    public const FEMALE_XS = 10;
    public const FEMALE_S = 11;
    public const FEMALE_M = 12;
    public const FEMALE_L = 13;
    public const FEMALE_XL = 14;
    public const MALE_XS = 20;
    public const MALE_S = 21;
    public const MALE_M = 22;
    public const MALE_L = 23;
    public const MALE_XL = 24;
    public const MALE_XXL = 25;
    public const MALE_XXXL = 26;
    public const UNISEX_XS = 30;
    public const UNISEX_S = 31;
    public const UNISEX_M = 32;
    public const UNISEX_L = 33;
    public const UNISEX_XL = 34;
    public const UNISEX_XXL = 35;
    public const UNISEX_XXXL = 36;

    private const NAMES = [
        self::NONE => 'enum.shirt_type.none',
        self::FEMALE_XS => 'enum.shirt_type.female_xs',
        self::FEMALE_S => 'enum.shirt_type.female_s',
        self::FEMALE_M => 'enum.shirt_type.female_m',
        self::FEMALE_L => 'enum.shirt_type.female_l',
        self::FEMALE_XL => 'enum.shirt_type.female_xl',
        self::MALE_XS => 'enum.shirt_type.male_xs',
        self::MALE_S => 'enum.shirt_type.male_s',
        self::MALE_M => 'enum.shirt_type.male_m',
        self::MALE_L => 'enum.shirt_type.male_l',
        self::MALE_XL => 'enum.shirt_type.male_xl',
        self::MALE_XXL => 'enum.shirt_type.male_xxl',
        self::MALE_XXXL => 'enum.shirt_type.male_xxxl',
        self::UNISEX_XS => 'enum.shirt_type.unisex_xs',
        self::UNISEX_S => 'enum.shirt_type.unisex_s',
        self::UNISEX_M => 'enum.shirt_type.unisex_m',
        self::UNISEX_L => 'enum.shirt_type.unisex_l',
        self::UNISEX_XL => 'enum.shirt_type.unisex_xl',
        self::UNISEX_XXL => 'enum.shirt_type.unisex_xxl',
        self::UNISEX_XXXL => 'enum.shirt_type.unisex_xxxl',
    ];

    /**
     * @return int[]
     */
    public static function getAvailableTypes(): array
    {
        return [
            self::NONE,
            self::UNISEX_XS,
            self::UNISEX_S,
            self::UNISEX_M,
            self::UNISEX_L,
            self::UNISEX_XL,
            self::UNISEX_XXL,
            self::UNISEX_XXXL,
        ];
    }
}
