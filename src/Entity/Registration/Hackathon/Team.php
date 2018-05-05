<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Registration\Hackathon;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\User\User;
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
     * @ORM\OneToMany(targetEntity="BalticRobo\Website\Entity\Registration\Hackathon\Member", mappedBy="team")
     *
     * @var Collection|Member[]
     */
    private $members;

    /**
     * @ORM\OneToOne(targetEntity="BalticRobo\Website\Entity\Registration\Hackathon\Member", mappedBy="team")
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

    public function getCaptain(): Member
    {
        return $this->captain;
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
