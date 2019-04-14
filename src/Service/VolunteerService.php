<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Volunteer;
use BalticRobo\Website\Model\Registration\VolunteerDTO;
use BalticRobo\Website\Repository\Registration\VolunteerRepository;

final class VolunteerService
{
    private $repository;

    public function __construct(VolunteerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function add(VolunteerDTO $dto, Event $event, \DateTimeImmutable $now): void
    {
        $entity = Volunteer::fromDTO($dto, $event, $now);

        $this->repository->save($entity);
    }
}
