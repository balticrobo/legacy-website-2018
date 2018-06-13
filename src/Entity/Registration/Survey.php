<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Model\Registration\SurveyDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="registration_surveys",
 * uniqueConstraints={@ORM\UniqueConstraint(columns={"type", "event_id", "created_by_id"})})
 * @ORM\Entity
 */
class Survey
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
     * @ORM\Column(type="json")
     */
    private $survey;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\Event\Event")
     */
    private $event;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="BalticRobo\Website\Entity\User\User")
     */
    private $createdBy;

    public static function createFromDTO(SurveyDTO $dto, Event $event, User $author, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->type = $dto->getType();
        $entity->survey = $dto->getData();
        $entity->event = $event;
        $entity->createdBy = $author;
        $entity->createdAt = $now;

        return $entity;
    }
}
