<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository\Registration\Competition;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use BalticRobo\Website\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TeamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function getByEventAndUser(Event $event, User $user): Collection
    {
        $records = $this->findBy(['event' => $event, 'createdBy' => $user]);

        return new ArrayCollection($records);
    }

    public function save(Team $team): void
    {
        $this->getEntityManager()->persist($team);
        $this->getEntityManager()->flush();
    }
}
