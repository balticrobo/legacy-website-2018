<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Registration\Hackathon;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Model\Registration\Hackathon\AddTeamDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="registration_teams_hackathon",
 * uniqueConstraints={@ORM\UniqueConstraint(columns={"name", "event_id"})})
 * @ORM\Entity
 */
class Team
{
    public const MAX_TEAMS = 1;
    public const MINIMUM_FULL_TEAM_MEMBERS = 4;
    public const MAX_MEMBERS = 6;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $city;

    /**
     * @ORM\Column(type="text")
     */
    private $whyYou;

    /**
     * @ORM\Column(type="text")
     */
    private $experience;

    /**
     * @ORM\OneToMany(targetEntity="BalticRobo\Website\Entity\Registration\Hackathon\Member", mappedBy="team",
     * cascade={"persist"})
     *
     * @var Collection|Member[]
     */
    private $members;

    /**
     * @ORM\OneToOne(targetEntity="BalticRobo\Website\Entity\Registration\Hackathon\Member")
     */
    private $captain;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Event\Event")
     */
    private $event;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\User\User")
     */
    private $createdBy;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public static function createFromAddDTO(AddTeamDTO $dto, Event $event, User $author, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->name = $dto->getName();
        $entity->city = $dto->getCity();
        $entity->whyYou = $dto->getWhyYou();
        $entity->experience = $dto->getExperience();
        $entity->event = $event;
        $entity->createdAt = $now;
        $entity->createdBy = $author;
        $entity->members = new ArrayCollection();
        $entity->captain = null;

        return $entity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getWhyYou(): string
    {
        return $this->whyYou;
    }

    public function getExperience(): string
    {
        return $this->experience;
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): void
    {
        $this->members->add($member);
    }

    public function getCaptain(): ?Member
    {
        return $this->captain;
    }

    public function hasCaptain(): bool
    {
        return (bool) $this->captain;
    }

    public function setCaptain(Member $captain): void
    {
        $this->captain = $captain;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }
}
