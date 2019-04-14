<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Model\Registration\VolunteerDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="volunteers")
 * @ORM\Entity
 */
final class Volunteer
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
}
