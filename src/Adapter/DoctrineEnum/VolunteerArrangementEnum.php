<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\DoctrineEnum;

final class VolunteerArrangementEnum
{
    use EnumTrait;

    public const POSTERING = 1;
    public const INFORMATION_MEETING = 2;
    public const PREPARING = 3;
    public const PREPARING_2 = 4;
    public const FIRST_DAY = 5;
    public const SECOND_DAY = 6;
    public const FIRST_NIGHT = 7;
    public const SECOND_NIGHT = 8;
    private const NAMES = [
        self::POSTERING => 'enum.volunteer_arrangement.postering',
        self::INFORMATION_MEETING => 'enum.volunteer_arrangement.information_meeting',
        self::PREPARING => 'enum.volunteer_arrangement.preparing',
        self::PREPARING_2 => 'enum.volunteer_arrangement.preparing_2',
        self::FIRST_DAY => 'enum.volunteer_arrangement.first_day',
        self::SECOND_DAY => 'enum.volunteer_arrangement.second_day',
        self::FIRST_NIGHT => 'enum.volunteer_arrangement.first_night',
        self::SECOND_NIGHT => 'enum.volunteer_arrangement.second_night',
    ];

    /**
     * @return int[]
     */
    public static function getAvailableTypes(): array
    {
        return [
            self::POSTERING,
            self::INFORMATION_MEETING,
            self::PREPARING,
            self::PREPARING_2,
            self::FIRST_DAY,
            self::SECOND_DAY,
            self::FIRST_NIGHT,
            self::SECOND_NIGHT,
        ];
    }
}
