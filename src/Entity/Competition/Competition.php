<?php declare(strict_types=1);

namespace BalticRobo\Website\Entity\Competition;

use BalticRobo\Website\Adapter\DoctrineEnum\RegistrationTypeEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="competitions")
 * @ORM\Entity
 */
class Competition
{
    public const REGISTRATION_TYPE_EVENT = 1;
    public const REGISTRATION_TYPE_HACKATHON = 2;
    public const REGISTRATION_TYPE_CONFERENCE = 3;

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

    /**
     * @ORM\Column(type="smallint")
     */
    private $sortOrder;

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

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }
}
