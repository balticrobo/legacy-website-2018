<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Competition;

use BalticRobo\Website\Adapter\DoctrineEnum\RegistrationTypeEnum;
use Doctrine\ORM\Mapping as ORM;

class Competition
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $slug;

    /**
     * @ORM\Column(type="smallint")
     */
    private $registrationType;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Competition\CompetitionGroup")
     */
    private $group;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getRegistrationType(): int
    {
        return $this->registrationType;
    }

    public function getNamedRegistrationType(): string
    {
        return RegistrationTypeEnum::getName($this->registrationType);
    }

    public function getGroup(): CompetitionGroup
    {
        return $this->group;
    }
}
