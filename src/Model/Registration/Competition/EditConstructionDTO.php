<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Registration\Competition;

use BalticRobo\Website\Entity\Registration\Competition\Construction;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class EditConstructionDTO
{
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

    public static function createFromEntity(Construction $entity): self
    {
        $dto = new self();
        $dto->name = $entity->getName();
        $dto->competitions = $entity->getCompetitions();
        $dto->creators = $entity->getCreators();

        return $dto;
    }

    public function getName(): ?string
    {
        return $this->name;
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
