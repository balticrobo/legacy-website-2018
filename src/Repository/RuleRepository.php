<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Rule\Rule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RuleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rule::class);
    }

    public function getCurrentRulesByLocale(Event $event, string $locale): Collection
    {
        $records = $this->createQueryBuilder('r')
            ->join(Event::class, 'e')
            ->where('e.id = :eventId')
            ->andWhere('r.locale = :locale')
            ->getQuery()
            ->setParameter('eventId', $event->getId())
            ->setParameter('locale', $locale)
            ->getResult();

        return new ArrayCollection($records);
    }
}
