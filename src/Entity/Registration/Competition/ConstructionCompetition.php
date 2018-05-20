<?php

declare(strict_types = 1);

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

    public static function create(Construction $construction, Competition $competition): self
    {
        $entity = new self();
        $entity->construction = $construction;
        $entity->competition = $competition;

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
}
