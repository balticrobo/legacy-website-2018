<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\DoctrineEnum;

class RegistrationTypeEnum
{
    use EnumTrait;

    public const COMPETITION = 1;
    public const HACKATHON = 2;
    public const CONFERENCE = 3;

    private const NAMES = [
        self::COMPETITION => 'enum.registration_type.competition',
        self::HACKATHON => 'enum.registration_type.hackathon',
        self::CONFERENCE => 'enum.registration_type.conference',
    ];

    /**
     * @return int[]
     */
    public static function getAvailableTypes(): array
    {
        return [
            self::COMPETITION,
            self::HACKATHON,
            self::CONFERENCE,
        ];
    }
}
