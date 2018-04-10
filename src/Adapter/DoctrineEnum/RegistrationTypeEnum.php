<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\DoctrineEnum;

class RegistrationTypeEnum
{
    public const COMPETITION = 1;
    public const HACKATHON = 2;
    public const CONFERENCE = 3;

    private const NAMES = [
        self::COMPETITION => 'enum.registration_type.competition',
        self::HACKATHON => 'enum.registration_type.hackathon',
        self::CONFERENCE => 'enum.registration_type.conference',
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
            self::COMPETITION,
            self::HACKATHON,
            self::CONFERENCE,
        ];
    }

    public function getFormData(): array
    {
        return [
            self::NAMES[self::COMPETITION] => self::COMPETITION,
            self::NAMES[self::HACKATHON] => self::HACKATHON,
            self::NAMES[self::CONFERENCE] => self::CONFERENCE,
        ];
    }
}
