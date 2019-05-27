<?php declare(strict_types=1);

namespace BalticRobo\Website\Adapter\DoctrineEnum;

final class VolunteerHelpInEnum implements EnumInterface
{
    use EnumTrait;

    public const WATCHING_OVER_HACKATHON = 1;
    public const WATCHING_OVER_ROOMS = 2;
    public const REGISTRATION = 3;
    public const JUDGEMENT_WITH_EXPERIENCE = 4;
    public const JUDGEMENT_WITHOUT_EXPERIENCE = 5;
    public const BE_ANCHROMAN = 6;
    public const SOCIAL_MEDIA_FAN = 7;
    public const PHOTOGRAPHY = 8;
    public const PARTNERS_CAREGIVER = 9;
    public const MEDICAL_ASSISTANCE = 10;
    public const MEDIA = 11;
    public const WORKSHOP_WITH_CHILDREN = 12;
    public const DRIVER_WITH_CAR = 13;
    public const GOLDEN_HAND = 14;
    public const CALLIGRAPHER = 15;
    public const STREAM_STUFF = 16;
    public const STAY_AT_ENTRANCE = 17;
    private const NAMES = [
        self::WATCHING_OVER_HACKATHON => 'enum.volunteer_help_in.watching_over_hackathon',
        self::WATCHING_OVER_ROOMS => 'enum.volunteer_help_in.watching_over_rooms',
        self::REGISTRATION => 'enum.volunteer_help_in.registration',
        self::JUDGEMENT_WITH_EXPERIENCE => 'enum.volunteer_help_in.judgement_with_experience',
        self::JUDGEMENT_WITHOUT_EXPERIENCE => 'enum.volunteer_help_in.judgement_without_experience',
        self::BE_ANCHROMAN => 'enum.volunteer_help_in.be_anchroman',
        self::SOCIAL_MEDIA_FAN => 'enum.volunteer_help_in.social_media_fan',
        self::PHOTOGRAPHY => 'enum.volunteer_help_in.photography',
        self::PARTNERS_CAREGIVER => 'enum.volunteer_help_in.partners_caregiver',
        self::MEDICAL_ASSISTANCE => 'enum.volunteer_help_in.medical_assistance',
        self::MEDIA => 'enum.volunteer_help_in.media',
        self::WORKSHOP_WITH_CHILDREN => 'enum.volunteer_help_in.workshop_with_children',
        self::DRIVER_WITH_CAR => 'enum.volunteer_help_in.driver_with_car',
        self::GOLDEN_HAND => 'enum.volunteer_help_in.golden_hand',
        self::CALLIGRAPHER => 'enum.volunteer_help_in.calligrapher',
        self::STREAM_STUFF => 'enum.volunteer_help_in.stream_stuff',
        self::STAY_AT_ENTRANCE => 'enum.volunteer_help_in.stay_at_entrance',
    ];

    public static function getAvailableTypes(): array
    {
        return [
            self::WATCHING_OVER_HACKATHON,
            self::WATCHING_OVER_ROOMS,
            self::REGISTRATION,
            self::JUDGEMENT_WITH_EXPERIENCE,
            self::JUDGEMENT_WITHOUT_EXPERIENCE,
            self::BE_ANCHROMAN,
            self::SOCIAL_MEDIA_FAN,
            self::PHOTOGRAPHY,
            self::PARTNERS_CAREGIVER,
            self::MEDICAL_ASSISTANCE,
            self::MEDIA,
            self::WORKSHOP_WITH_CHILDREN,
            self::DRIVER_WITH_CAR,
            self::GOLDEN_HAND,
            self::CALLIGRAPHER,
            self::STREAM_STUFF,
            self::STAY_AT_ENTRANCE,
        ];
    }

    private function __construct()
    {
    }
}
