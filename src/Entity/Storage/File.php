<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Storage;

use BalticRobo\Website\Model\Cms\AddFileDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="storage_files")
 * @ORM\Entity
 */
class File implements StorageInterface
{
    public const LOCATION = __DIR__ . '/../../../public/upload/';
    private const URL = '/upload/';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $originalFilename;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $filename;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    public static function createFromAddDTO(AddFileDTO $dto, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->description = $dto->getDescription();
        $entity->originalFilename = $dto->getFile()->getClientOriginalName();
        $entity->filename = self::generateName() . ".{$dto->getFile()->getClientOriginalExtension()}";
        $entity->createdAt = $now;

        return $entity;
    }

    public function getAddress(): string
    {
        return self::URL . $this->filename;
    }

    public function getOriginalFilename(): string
    {
        return $this->originalFilename;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    private static function generateName(): string
    {
        return md5(uniqid());
    }
}
