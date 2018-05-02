<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Registration\Competition;

use BalticRobo\Website\Entity\Event\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="registration_teams",
 * uniqueConstraints={@ORM\UniqueConstraint(columns={"identifier", "event_id"})})
 * @ORM\Entity
 */
class Team
{
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
     * @ORM\Column(type="string", length=30)
     */
    private $scientificOrganization;

    /**
     * @ORM\OneToMany(targetEntity="BalticRobo\Website\Entity\Registration\Competition\Member", mappedBy="team")
     *
     * @var Collection|Member[]
     */
    private $members;

    /**
     * @ORM\OneToMany(targetEntity="BalticRobo\Website\Entity\Registration\Competition\Construction", mappedBy="team")
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
     * @ORM\OneToOne(targetEntity="BalticRobo\Website\Entity\User\User")
     */
    private $createdBy;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->constructions = new ArrayCollection();
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

    public function getConstructions(): Collection
    {
        return $this->constructions;
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
