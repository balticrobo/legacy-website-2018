<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Competition;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="competition_groups")
 * @ORM\Entity
 */
class CompetitionGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visibleAsTile = true;

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

    public function isVisibleAsTile(): bool
    {
        return $this->visibleAsTile;
    }
}
