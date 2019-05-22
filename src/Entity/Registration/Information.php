<?php declare(strict_types=1);

namespace BalticRobo\Website\Entity\Registration;

use BalticRobo\Website\Adapter\DoctrineEnum\InformationTypeEnum;
use BalticRobo\Website\Entity\Event\Event;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="registration_information")
 * @ORM\Entity
 */
class Information
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Event\Event")
     */
    private $event;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getNamedType(): string
    {
        return InformationTypeEnum::getName($this->type);
    }

    public function getFontAwesomeType(): string
    {
        return InformationTypeEnum::getFontAwesomeName($this->type);
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
