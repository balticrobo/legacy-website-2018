<?php declare(strict_types=1);

namespace BalticRobo\Website\Model\Registration\Competition;

use BalticRobo\Website\Adapter\DoctrineEnum\ShirtTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

class AddMemberDTO
{
    /**
     * @Assert\NotBlank(message="member_add.forename.not_blank")
     * @Assert\Length(
     *     min=3, minMessage="member_add.forename.length.min",
     *     max=30, maxMessage="member_add.forename.length.max"
     * )
     */
    private $forename;

    /**
     * @Assert\NotBlank(message="member_add.surname.not_blank")
     * @Assert\Length(
     *     min=3, minMessage="member_add.surname.length.min",
     *     max=40, maxMessage="member_add.surname.length.max"
     * )
     */
    private $surname;

    /**
     * @Assert\NotBlank(message="member_add.shirt_type.not_blank")
     * @Assert\Choice(callback="validateShirtType", message="member_add.shirt_type.choice")
     */
    private $shirtType;

    public function getForename(): ?string
    {
        return $this->forename;
    }

    public function setForename(string $forename): void
    {
        $this->forename = $forename;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getShirtType(): ?int
    {
        return $this->shirtType;
    }

    public function setShirtType(int $shirtType): void
    {
        $this->shirtType = $shirtType;
    }

    public static function validateShirtType(): array
    {
        return ShirtTypeEnum::getAvailableTypes();
    }
}
