<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository\Registration\Hackathon;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Hackathon\Member;
use BalticRobo\Website\Entity\Registration\Hackathon\Team;
use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Exception\CompetitorZone\TeamNotFoundException;
use BalticRobo\Website\Model\Judge\RegistrationSearchDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TeamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function getById(int $id): Team
    {
        $record = $this->find($id);
        if (!$record) {
            throw new TeamNotFoundException();
        }

        return $record;
    }

    public function getByEventAndUser(Event $event, User $user): Collection
    {
        $records = $this->findBy(['event' => $event, 'createdBy' => $user]);

        return new ArrayCollection($records);
    }

    public function getByEventAndName(Event $event, string $name): Team
    {
        $record = $this->findOneBy(['name' => $name, 'event' => $event]);
        if (!$record) {
            throw new TeamNotFoundException();
        }

        return $record;
    }

    public function getFilteredByEvent(RegistrationSearchDTO $dto, Event $event): Collection
    {
        $query = $this->createQueryBuilder('t')
            ->join(Member::class, 'm', Join::WITH, 't.id = m.team')
            ->where('t.event = :event')
            ->setParameter('event', $event)
            ->orderBy('t.name', 'ASC');
        if ($dto->getTeamNameOrIdentifier()) {
            $query->andWhere('(t.name LIKE :name1)')->setParameter('name1', "%{$dto->getTeamNameOrIdentifier()}%");
        }
        if ($dto->getMemberSurname()) {
            $query->andWhere('m.surname LIKE :surname')->setParameter('surname', "%{$dto->getMemberSurname()}%");
        }

        return new ArrayCollection($query->getQuery()->execute());
    }

    public function save(Team $team): void
    {
        $this->getEntityManager()->persist($team);
        $this->getEntityManager()->flush();
    }

    public function allowToStartInEvent(Team $team): void
    {
        $this->getEntityManager()->merge(Team::allowToStartInEvent($team));
        $this->getEntityManager()->flush();
    }

    public function disallowToStartInEvent(Team $team): void
    {
        $this->getEntityManager()->merge(Team::disallowToStartInEvent($team));
        $this->getEntityManager()->flush();
    }
}
