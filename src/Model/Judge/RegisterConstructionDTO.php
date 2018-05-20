<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Judge;

class RegisterConstructionDTO
{
    private $id;
    private $competitionId;
    private $presence = false;
    private $technicalValidationPassed = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCompetitionId(): ?int
    {
        return $this->competitionId;
    }

    public function setCompetitionId(int $competitionId): void
    {
        $this->competitionId = $competitionId;
    }

    public function getPresence(): bool
    {
        return $this->presence;
    }

    public function setPresence(bool $presence): void
    {
        $this->presence = $presence;
    }

    public function getTechnicalValidationPassed(): bool
    {
        return $this->technicalValidationPassed;
    }

    public function setTechnicalValidationPassed(bool $technicalValidationPassed): void
    {
        $this->technicalValidationPassed = $technicalValidationPassed;
    }
}
