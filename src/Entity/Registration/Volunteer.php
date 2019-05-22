<?php declare(strict_types=1);

namespace BalticRobo\Website\Entity\Registration;

use BalticRobo\Website\Adapter\DoctrineEnum\ShirtTypeEnum;
use BalticRobo\Website\Adapter\DoctrineEnum\VolunteerArrangementEnum;
use BalticRobo\Website\Adapter\DoctrineEnum\VolunteerHelpInEnum;
use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Model\Registration\VolunteerDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="volunteers")
 * @ORM\Entity
 */
class Volunteer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=120)
     */
    private $name;
    /**
     * @ORM\Column(type="smallint")
     */
    private $birthYear;
    /**
     * @ORM\Column(type="string", length=9)
     */
    private $phoneNumber;
    /**
     * @ORM\Column(type="string", length=80)
     */
    private $email;
    /**
     * @ORM\Column(type="json")
     */
    private $arrangementDays;
    /**
     * @ORM\Column(type="json")
     */
    private $helpIn;
    /**
     * @ORM\Column(type="boolean")
     */
    private $beenVolunteer;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $beenVolunteerDuties;
    /**
     * @ORM\Column(type="smallint")
     */
    private $shirtType;
    /**
     * @ORM\Column(type="json")
     */
    private $givenShirts = [];
    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Event\Event")
     */
    private $event;
    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    private function __construct()
    {
    }

    public static function fromDto(VolunteerDTO $dto, Event $event, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->name = $dto->name;
        $entity->birthYear = $dto->birthYear;
        $entity->phoneNumber = $dto->phoneNumber;
        $entity->email = $dto->email;
        $entity->arrangementDays = $dto->arrangementDays;
        $entity->helpIn = $dto->helpIn;
        $entity->beenVolunteer = $dto->beenVolunteer;
        $entity->beenVolunteerDuties = $dto->beenVolunteerDuties;
        $entity->shirtType = $dto->shirtType;
        $entity->event = $event;
        $entity->createdAt = $now;

        return $entity;
    }

    public static function giveShirt(self $entity, int $day, \DateTimeImmutable $now): self
    {
        if (isset($entity->givenShirts[$day])) {
            throw new \Exception('Shirt already given!'); /// TODO: Change to correct Exception
        }
        $entity->givenShirts[$day] = $now->getTimestamp();

        return $entity;
    }

    public static function takeShirt(self $entity, int $day): self
    {
        unset($entity->givenShirts[$day]);

        return $entity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        $currentYear = (int) (new \DateTimeImmutable())->format('Y');

        return $currentYear - $this->birthYear;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isBeenVolunteer(): bool
    {
        return $this->beenVolunteer;
    }

    public function getBeenVolunteerDuties(): ?string
    {
        return $this->beenVolunteerDuties;
    }

    public function getArrangementDays(): array
    {
        return array_map(function (int $arrangement): string {
            return VolunteerArrangementEnum::getName($arrangement);
        }, $this->arrangementDays);
    }

    public function getHelpIn(): array
    {
        return array_map(function (int $helpIn): string {
            return VolunteerHelpInEnum::getName($helpIn);
        }, $this->helpIn);
    }

    public function getShirtType(): string
    {
        return ShirtTypeEnum::getName($this->shirtType);
    }

    public function isShirtGiven(int $day): bool
    {
        return isset($this->givenShirts[$day]);
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
