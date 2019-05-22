<?php declare(strict_types=1);

namespace BalticRobo\Website\Entity\Registration\Competition;

use BalticRobo\Website\Entity\Competition\Competition;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="registration_constructions_competitions")
 * @ORM\Entity
 */
class ConstructionCompetition
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Registration\Competition\Construction",
     * inversedBy="competitions")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $construction;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Competition\Competition")
     */
    private $competition;

    /**
     * @ORM\Column(type="timestamp_immutable", nullable=true)
     */
    private $presenceCheckedAt;

    /**
     * @ORM\Column(type="timestamp_immutable", nullable=true)
     */
    private $techValidatedAt;

    public static function create(Construction $construction, Competition $competition): self
    {
        $entity = new self();
        $entity->construction = $construction;
        $entity->competition = $competition;

        return $entity;
    }

    public static function editFromRegisterTeam(
        self $entity,
        bool $isPresent,
        bool $isTechValid,
        \DateTimeImmutable $now
    ): self {
        // TODO: Refactor it
        if ($isPresent && !$entity->presenceCheckedAt) {
            $entity->presenceCheckedAt = $now;
        } elseif ($isPresent && $entity->presenceCheckedAt) {
            $entity->presenceCheckedAt = null;
        }
        if ($isTechValid && !$entity->techValidatedAt) {
            $entity->techValidatedAt = $now;
        } elseif ($isTechValid && $entity->techValidatedAt) {
            $entity->techValidatedAt = null;
        }

        return $entity;
    }

    public function getConstruction(): Construction
    {
        return $this->construction;
    }

    public function getCompetition(): Competition
    {
        return $this->competition;
    }

    public function getPresenceCheckedAt(): ?\DateTimeImmutable
    {
        return $this->presenceCheckedAt;
    }

    public function getTechValidatedAt(): ?\DateTimeImmutable
    {
        return $this->techValidatedAt;
    }
}
