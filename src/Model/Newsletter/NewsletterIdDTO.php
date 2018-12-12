<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Newsletter;

use BalticRobo\Website\Exception\Newsletter\InvalidIdentifierException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class NewsletterIdDTO
{
    /**
     * @Assert\NotBlank(message="newsletter.id.not_blank")
     * @Assert\Uuid(message="newsletter.id.uuid")
     */
    private $id;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function setId(string $uuid): void
    {
        try {
            $this->id = Uuid::fromString($uuid);
        } catch (InvalidUuidStringException $e) {
            throw new InvalidIdentifierException();
        }
    }
}
