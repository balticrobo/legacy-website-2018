<?php declare(strict_types=1);

namespace BalticRobo\Website\Entity\Newsletter;

use BalticRobo\Website\Model\Newsletter\NewsletterEmailDTO;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="newsletter_emails")
 */
class Newsletter
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @var UuidInterface
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    public static function createFromEmailDTO(NewsletterEmailDTO $dto, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->email = $dto->getEmail();
        $entity->createdAt = $now;

        return $entity;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCsvRecord(): array
    {
        return [
            $this->email,
            $this->createdAt->format('Y-m-d H:i'),
        ];
    }
}
