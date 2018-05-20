<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Judge;

class RegistrationSearchDTO
{
    private $teamNameOrIdentifier;
    private $memberSurname;

    public function getTeamNameOrIdentifier(): ?string
    {
        return $this->teamNameOrIdentifier;
    }

    public function setTeamNameOrIdentifier(string $teamNameOrIdentifier): void
    {
        $this->teamNameOrIdentifier = $teamNameOrIdentifier;
    }

    public function getMemberSurname(): ?string
    {
        return $this->memberSurname;
    }

    public function setMemberSurname(string $robotName): void
    {
        $this->memberSurname = $robotName;
    }
}
