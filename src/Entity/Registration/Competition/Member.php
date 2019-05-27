<?php declare(strict_types=1);

namespace BalticRobo\Website\Entity\Registration\Competition;

use BalticRobo\Website\Adapter\Enum\ShirtTypeEnum;
use BalticRobo\Website\Model\Registration\Competition\AddMemberDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="registration_members")
 * @ORM\Entity
 */
class Member
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $forename;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $surname;

    /**
     * @ORM\Column(type="smallint")
     */
    private $shirtType;

    /**
     * @ORM\Column(type="timestamp_immutable", nullable=true)
     *
     * @var \DateTimeImmutable
     */
    private $presenceCheckedAt;

    /**
     * @ORM\Column(type="timestamp_immutable", nullable=true)
     *
     * @var \DateTimeImmutable
     */
    private $shirtGivenOutAt;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Registration\Competition\Team", inversedBy="members")
     */
    private $team;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    public static function createFromAddDTO(AddMemberDTO $memberDTO, Team $team, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->forename = $memberDTO->getForename();
        $entity->surname = $memberDTO->getSurname();
        $entity->shirtType = $memberDTO->getShirtType();
        $entity->team = $team;
        $entity->createdAt = $now;

        return $entity;
    }

    public static function editFromRegisterTeam(
        self $entity,
        bool $isPresent,
        bool $isShirtGivenOut,
        \DateTimeImmutable $now
    ): self {
        // TODO: Refactor it
        if ($isPresent && !$entity->presenceCheckedAt) {
            $entity->presenceCheckedAt = $now;
        } elseif ($isPresent && $entity->presenceCheckedAt) {
            $entity->presenceCheckedAt = null;
        }
        if ($isShirtGivenOut && !$entity->shirtGivenOutAt) {
            $entity->shirtGivenOutAt = $now;
        } elseif ($isShirtGivenOut && $entity->shirtGivenOutAt) {
            $entity->shirtGivenOutAt = null;
        }

        return $entity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getForename(): string
    {
        return $this->forename;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getName(): string
    {
        return "{$this->forename} {$this->surname}";
    }

    public function getShirtType(): int
    {
        return $this->shirtType;
    }

    public function getNamedShirtType(): string
    {
        return ShirtTypeEnum::getName($this->shirtType);
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getPresenceCheckedAt(): ?\DateTimeImmutable
    {
        return $this->presenceCheckedAt;
    }

    public function getShirtGivenOutAt(): ?\DateTimeImmutable
    {
        return $this->shirtGivenOutAt;
    }
}
