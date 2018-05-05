<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Registration\Hackathon;

use BalticRobo\Website\Adapter\DoctrineEnum\ShirtTypeEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="registration_members_hackathon")
 * @ORM\Entity
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $forename;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $surname;

    /**
     * @ORM\Column(type="smallint")
     */
    private $age;

    /**
     * @ORM\Column(type="smallint")
     */
    private $shirtType;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Registration\Hackathon\Team", inversedBy="members")
     */
    private $team;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getForename(): string
    {
        return $this->forename;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getShirtType(): int
    {
        return $this->shirtType;
    }

    public function getNamedShirtType(): string
    {
        return ShirtTypeEnum::getName($this->shirtType);
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
