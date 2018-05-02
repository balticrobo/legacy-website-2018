<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Registration\Competition;

use BalticRobo\Website\Entity\Competition\Competition;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="registration_constructions")
 * @ORM\Entity
 */
class Construction
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
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Registration\Competition\Team",
     *     inversedBy="constructions"
     * )
     */
    private $team;

    /**
     * @ORM\ManyToMany(targetEntity="BalticRobo\Website\Entity\Competition\Competition")
     * @ORM\JoinTable(name="registration_constructions_competitions",
     *     joinColumns={@ORM\JoinColumn(name="construction_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="competition_id", referencedColumnName="id")}
     * )
     *
     * @var Collection|Competition[]
     */
    private $competitions;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Registration\Competition\Member")
     *
     * @var Collection|Member[]
     */
    private $creators;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    public function __construct()
    {
        $this->competitions = new ArrayCollection();
        $this->creators = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    public function getCreators(): Collection
    {
        return $this->creators;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
