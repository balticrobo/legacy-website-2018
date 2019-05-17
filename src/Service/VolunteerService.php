<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Volunteer;
use BalticRobo\Website\Model\Registration\VolunteerDTO;
use BalticRobo\Website\Repository\Registration\VolunteerRepository;
use Doctrine\Common\Collections\Collection;

final class VolunteerService
{
    private $repository;

    public function __construct(VolunteerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getById(int $id): Volunteer
    {
        return $this->repository->getById($id);
    }

    public function getByEvent(Event $event): Collection
    {
        return $this->repository->getByEvent($event);
    }

    public function add(VolunteerDTO $dto, Event $event, \DateTimeImmutable $now): void
    {
        $entity = Volunteer::fromDTO($dto, $event, $now);

        $this->repository->save($entity);
    }

    public function giveShirt(int $id, int $day, \DateTimeImmutable $now): void
    {
        $current = $this->getById($id);
        $new = Volunteer::giveShirt($current, $day, $now);

        $this->repository->update($new);
    }

    public function takeShirt(int $id, int $day): void
    {
        $current = $this->getById($id);
        $new = Volunteer::takeShirt($current, $day);

        $this->repository->update($new);
    }
}
