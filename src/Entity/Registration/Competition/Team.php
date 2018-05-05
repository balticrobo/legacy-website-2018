<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Registration\Competition;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Model\Registration\Competition\AddTeamDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="registration_teams", uniqueConstraints={@ORM\UniqueConstraint(columns={"identifier", "event_id"})})
 * @ORM\Entity(repositoryClass="BalticRobo\Website\Repository\Registration\Competition\TeamRepository")
 */
class Team
{
    public const MAX_MEMBERS = 4;

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
     * @ORM\Column(type="string", length=4)
     */
    private $identifier;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $scientificOrganization;

    /**
     * @ORM\OneToMany(targetEntity="BalticRobo\Website\Entity\Registration\Competition\Member", mappedBy="team",
     * cascade={"persist"})
     *
     * @var Collection|Member[]
     */
    private $members;

    /**
     * @ORM\OneToMany(targetEntity="BalticRobo\Website\Entity\Registration\Competition\Construction", mappedBy="team",
     * cascade={"persist"})
     *
     * @var Collection|Construction[]
     */
    private $constructions;

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
        $this->constructions = new ArrayCollection();
    }

    public static function createFromAddDTO(AddTeamDTO $dto, Event $event, User $author, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->name = $dto->getName();
        $entity->identifier = $dto->getIdentifier();
        $entity->city = $dto->getCity();
        $entity->scientificOrganization = $dto->getScientificOrganization();
        $entity->event = $event;
        $entity->createdAt = $now;
        $entity->createdBy = $author;
        $entity->members = new ArrayCollection();
        $entity->constructions = new ArrayCollection();

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

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getScientificOrganization(): ?string
    {
        return $this->scientificOrganization;
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): void
    {
        $this->members->add($member);
    }

    public function getConstructions(): Collection
    {
        return $this->constructions;
    }

    public function addConstruction(Construction $construction): void
    {
        $this->constructions->add($construction);
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
