<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Registration\Competition;

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
     * TODO: OwnAssert\TeamExists(message="team_add.name.already_exists")
     */
    private $name;

    /**
     * @Assert\NotBlank(message="team_add.identifier.not_blank")
     * @Assert\Length(
     *     min=2, minMessage="team_add.identifier.length.min",
     *     max=4, maxMessage="team_add.identifier.length.max"
     * )
     * @Assert\Regex(pattern="/^\w+$/", message="team_add.identifier.alphanumeric")
     */
    private $identifier;

    /**
     * @Assert\NotBlank(message="team_add.city.not_blank")
     * @Assert\Length(
     *     min=2, minMessage="team_add.city.length.min",
     *     max=30, maxMessage="team_add.city.length.max"
     * )
     */
    private $city;

    /**
     * @Assert\Length(max=30, maxMessage="team_add.scientific_organization.length.max")
     */
    private $scientificOrganization;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = strtoupper($identifier);
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getScientificOrganization(): ?string
    {
        return $this->scientificOrganization;
    }

    public function setScientificOrganization(?string $scientificOrganization): void
    {
        $this->scientificOrganization = $scientificOrganization;
    }
}
