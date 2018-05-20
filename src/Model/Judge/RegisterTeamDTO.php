<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Judge;

use BalticRobo\Website\Entity\Registration\Competition\Member;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class RegisterTeamDTO
{
    private $id;
    private $members;
    private $constructions;

    public static function createFromTeamEntity(Team $team): self
    {
        $dto = new self();
        $dto->id = $team->getId();
        $dto->members = $team->getMembers()->map(function (Member $member) {
            return RegisterMemberDTO::createFromMemberEntity($member);
        });
        $dto->constructions = new ArrayCollection();

        return $dto;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function getConstructions(): Collection
    {
        return $this->constructions;
    }
}
