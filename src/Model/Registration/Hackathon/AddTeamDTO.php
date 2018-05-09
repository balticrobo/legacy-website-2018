<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Registration\Hackathon;

use BalticRobo\Website\Adapter\FormValidation as OwnAssert;
use Symfony\Component\Validator\Constraints as Assert;

class AddTeamDTO
{
    /**
     * @Assert\NotBlank(message="team_add.name.not_blank")
     * @Assert\Length(
     *     min=3, minMessage="team_add.name.length.min",
     *     max=50, maxMessage="team_add.name.length.max"
     * )
     * @OwnAssert\TeamExists(message="team_add.name.already_exists")
     */
    private $name;

    /**
     * @Assert\NotBlank(message="team_add.city.not_blank")
     * @Assert\Length(
     *     min=2, minMessage="team_add.city.length.min",
     *     max=30, maxMessage="team_add.city.length.max"
     * )
     */
    private $city;

    /**
     * @Assert\NotBlank(message="team_add.why_you.not_blank")
     * @Assert\Length(
     *     min=15, minMessage="team_add.why_you.length.min",
     *     max=400, maxMessage="team_add.why_you.length.max"
     * )
     */
    private $whyYou;

    /**
     * @Assert\NotBlank(message="team_add.experience.not_blank")
     * @Assert\Length(
     *     min=15, minMessage="team_add.experience.length.min",
     *     max=400, maxMessage="team_add.experience.length.max"
     * )
     */
    private $experience;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getWhyYou(): ?string
    {
        return $this->whyYou;
    }

    public function setWhyYou(string $whyYou): void
    {
        $this->whyYou = $whyYou;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): void
    {
        $this->experience = $experience;
    }
}
