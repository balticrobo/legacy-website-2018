<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\DoctrineEnum;

class ShirtTypeEnum
{
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

    private const NAMES = [
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
    ];

    public static function getName(int $enum): string
    {
        if (!isset(self::NAMES[$enum])) {
            throw new UnknownEnumException((string) $enum);
        }

        return self::NAMES[$enum];
    }

    /**
     * @return int[]
     */
    public static function getAvailableTypes(): array
    {
        return [
            self::FEMALE_XS,
            self::FEMALE_S,
            self::FEMALE_M,
            self::FEMALE_L,
            self::FEMALE_XL,
            self::MALE_XS,
            self::MALE_S,
            self::MALE_M,
            self::MALE_L,
            self::MALE_XL,
            self::MALE_XXL,
            self::MALE_XXXL,
        ];
    }

    public function getFormData(): array
    {
        return [
            self::NAMES[self::FEMALE_XS] => self::FEMALE_XS,
            self::NAMES[self::FEMALE_S] => self::FEMALE_S,
            self::NAMES[self::FEMALE_M] => self::FEMALE_M,
            self::NAMES[self::FEMALE_L] => self::FEMALE_L,
            self::NAMES[self::FEMALE_XL] => self::FEMALE_XL,
            self::NAMES[self::MALE_XS] => self::MALE_XS,
            self::NAMES[self::MALE_S] => self::MALE_S,
            self::NAMES[self::MALE_M] => self::MALE_M,
            self::NAMES[self::MALE_L] => self::MALE_L,
            self::NAMES[self::MALE_XL] => self::MALE_XL,
            self::NAMES[self::MALE_XXL] => self::MALE_XXL,
            self::NAMES[self::MALE_XXXL] => self::MALE_XXXL,
        ];
    }
}
