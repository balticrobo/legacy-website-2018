<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Registration\Hackathon;

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
     * @Assert\NotBlank(message="member_add.age.not_blank")
     * @Assert\Range(min="18", minMessage="member_add.age.range.min")
     */
    private $age;

    /**
     * @Assert\NotBlank(message="member_add.shirt_type.not_blank")
     * @Assert\Choice(callback="validateShirtType", message="member_add.shirt_type.choice")
     */
    private $shirtType;

    private $captain = false;

    /**
     * @Assert\NotBlank(message="member_add.phone_number.not_blank")
     * @Assert\Regex(pattern="/^[0-9]{9}$/", message="member_add.phone_number.regex")
     */
    private $phoneNumber;

    /**
     * @Assert\NotBlank(message="member_add.email.not_blank")
     * @Assert\Email(message="member_add.email.email")
     */
    private $email;

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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
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

    public function isCaptain(): bool
    {
        return $this->captain;
    }

    public function setCaptain(bool $captain): void
    {
        $this->captain = $captain;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
