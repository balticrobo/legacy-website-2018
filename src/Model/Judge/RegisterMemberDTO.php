<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Judge;

use BalticRobo\Website\Entity\Registration\Competition\Member;

class RegisterMemberDTO
{
    private $id;
    private $presence = false;
    private $shirtGivenOut = false;

    public static function createFromMemberEntity(Member $member): self
    {
        $dto = new self();
        $dto->id = $member->getId();

        return $dto;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresence(): bool
    {
        return $this->presence;
    }

    public function setPresence(bool $presence): void
    {
        $this->presence = $presence;
    }

    public function getShirtGivenOut(): bool
    {
        return $this->shirtGivenOut;
    }

    public function setShirtGivenOut(bool $shirtGivenOut): void
    {
        $this->shirtGivenOut = $shirtGivenOut;
    }
}
