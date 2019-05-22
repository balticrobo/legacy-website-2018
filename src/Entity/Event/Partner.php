<?php declare(strict_types=1);

namespace BalticRobo\Website\Entity\Event;

use BalticRobo\Website\Adapter\DoctrineEnum\PartnerTypeEnum;
use BalticRobo\Website\Entity\Storage\File;
use BalticRobo\Website\Model\Cms\AddPartnerDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="event_partners")
 * @ORM\Entity
 */
class Partner
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Event\Event")
     */
    private $event;

    /**
     * @ORM\Column(type="string", length=140)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Storage\File")
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $url;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sortOrder;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    public static function createFromAddDTO(AddPartnerDTO $dto, File $file, Event $event, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->event = $event;
        $entity->name = $dto->getName();
        $entity->file = $file;
        $entity->url = $dto->getUrl();
        $entity->type = $dto->getType();
        $entity->sortOrder = $dto->getSortOrder();
        $entity->createdAt = $now;

        return $entity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getNamedType(): string
    {
        return PartnerTypeEnum::getName($this->type);
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
