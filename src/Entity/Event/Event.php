<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Event;

use BalticRobo\Website\Entity\Storage\File;
use BalticRobo\Website\Exception\Event\EventCompetitionNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="BalticRobo\Website\Repository\EventRepository")
 */
class Event
{
    private const REOPEN_REGISTRATION_AFTER = 'PT20H';
    private const CLOSE_SURVEYS_AFTER = 'P2M';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $year;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $eventStartsAt;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $registrationStartsAt;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $registrationStopsAt;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $registrationEndsAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $draft = true;

    /**
     * @ORM\Column(name="volunteer_registration", type="boolean")
     */
    private $enabledVolunteerRegistration = false;

    /**
     * @ORM\OneToOne(targetEntity="BalticRobo\Website\Entity\Storage\File")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $schedule;

    /**
     * @ORM\OneToMany(targetEntity="BalticRobo\Website\Entity\Event\EventCompetition", mappedBy="event")
     */
    private $competitions;

    public function __construct()
    {
        $this->competitions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getYear(): int
    {
        return (int) $this->year;
    }

    public function getEventStartsAt(): \DateTimeImmutable
    {
        return $this->eventStartsAt;
    }

    public function getRegistrationStartsAt(): \DateTimeImmutable
    {
        return $this->registrationStartsAt;
    }

    public function getRegistrationStopsAt(): \DateTimeImmutable
    {
        return $this->registrationStopsAt;
    }

    public function getRegistrationRestartsAt(): \DateTimeImmutable
    {
        return $this->registrationStopsAt->add(new \DateInterval(self::REOPEN_REGISTRATION_AFTER));
    }

    public function getRegistrationEndsAt(): \DateTimeImmutable
    {
        return $this->registrationEndsAt;
    }

    public function isActiveRegistration(\DateTimeImmutable $now = null): bool
    {
        if (null === $now) {
            $now = new \DateTimeImmutable();
        }

        return $this->registrationStartsAt < $now && $this->registrationStopsAt > $now;
    }

    public function isActiveRegistrationAgain(\DateTimeImmutable $now = null): bool
    {
        if (null === $now) {
            $now = new \DateTimeImmutable();
        }

        return $this->getRegistrationRestartsAt() < $now
            && $this->registrationEndsAt > $now;
    }

    public function isClosedRegistration(\DateTimeImmutable $now = null): bool
    {
        if (null === $now) {
            $now = new \DateTimeImmutable();
        }

        return $this->registrationEndsAt < $now
            && $this->eventStartsAt > $now;
    }

    public function isActiveSurvey(\DateTimeImmutable $now = null): bool
    {
        if (null === $now) {
            $now = new \DateTimeImmutable();
        }

        return $this->eventStartsAt < $now
            && $this->eventStartsAt->add(new \DateInterval(self::CLOSE_SURVEYS_AFTER)) > $now;
    }

    public function isDraft(): bool
    {
        return $this->draft;
    }

    public function isEnabledVolunteerRegistration(): bool
    {
        return $this->enabledVolunteerRegistration;
    }

    public function getCompetitionBySlug(string $slug): EventCompetition
    {
        $competition = $this->competitions->filter(function (EventCompetition $competition) use ($slug) {
            if ($competition->getCompetition()->getSlug() === $slug) {
                return $competition;
            }

            return null;
        })->first();
        if (!$competition) {
            throw new EventCompetitionNotFoundException();
        }

        return $competition;
    }

    public function getSchedule(): ?File
    {
        return $this->schedule;
    }
}
