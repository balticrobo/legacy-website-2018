<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Survey;
use BalticRobo\Website\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SurveyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Survey::class);
    }

    public function isSent(User $user, int $type, Event $event): bool
    {
        return (bool) $this->createQueryBuilder('s')
            ->where('s.createdBy = :user')
            ->andWhere('s.type = :type')
            ->andWhere('s.event = :event')
            ->getQuery()
            ->setParameter('user', $user)
            ->setParameter('type', $type)
            ->setParameter('event', $event)
            ->getOneOrNullResult();
    }

    public function save(Survey $survey): void
    {
        $this->getEntityManager()->persist($survey);
        $this->getEntityManager()->flush();
    }
}
