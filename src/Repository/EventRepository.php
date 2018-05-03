<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Exception\Event\EventnNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getCurrentEvent(): Event
    {
        return $this->createQueryBuilder('e')
            ->where('e.draft = FALSE')
            ->orderBy('e.eventStartsAt', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getSingleResult();
    }

    public function getEventByYear(int $year): Event
    {
        $record = $this->findOneBy(['year' => $year]);
        if (!$record) {
            throw new EventnNotFoundException();
        }

        return $record;
    }
}
