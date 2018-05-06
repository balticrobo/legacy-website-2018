<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Registration\Competition;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class AddConstructionDTO
{
    /**
     * @Assert\NotBlank(message="construction_add.name.not_blank")
     * @Assert\Length(
     *     min=3, minMessage="construction_add.name.length.min",
     *     max=30, maxMessage="construction_add.name.length.max"
     * )
     * TODO: OwnAssert\ConstructionExists(message="construction_add.name.already_exists")
     */
    private $name;

    /**
     * @Assert\Count(min="1", minMessage="construction_add.competitions.count.min")
     */
    private $competitions;

    private $creators;

    public function __construct()
    {
        $this->competitions = new ArrayCollection();
        $this->creators = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCompetitions(): ?Collection
    {
        return $this->competitions;
    }

    public function setCompetitions(Collection $competitions): void
    {
        $this->competitions = $competitions;
    }

    public function getCreators(): Collection
    {
        return $this->creators;
    }

    public function setCreators(Collection $creators): void
    {
        $this->creators = $creators;
    }
}
