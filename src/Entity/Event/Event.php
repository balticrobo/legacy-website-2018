<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Event;

use BalticRobo\Website\Exception\Event\EventCompetitionNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="BalticRobo\Website\Repository\EventRepository")
 */
class Event
{
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
    private $registrationEndsAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $draft = true;

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

    public function isActiveRegistration(\DateTimeImmutable $now): bool
    {
        return $this->registrationStartsAt > $now && $this->registrationEndsAt < $now;
    }

    public function isDraft(): bool
    {
        return $this->draft;
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
}
