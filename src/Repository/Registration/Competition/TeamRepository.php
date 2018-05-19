<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository\Registration\Competition;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Competition\Member;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use BalticRobo\Website\Entity\User\User;
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

    public function getByIdentifierAndEvent(string $identifier, Event $event): Team
    {
        $record = $this->findOneBy(['event' => $event, 'identifier' => $identifier]);
        if (!$record) {
            throw new \Exception(); // TODO: Throw correct exception
        }

        return $record;
    }

    public function getByEventAndUser(Event $event, User $user): Collection
    {
        $records = $this->findBy(['event' => $event, 'createdBy' => $user]);

        return new ArrayCollection($records);
    }

    public function getFilteredByEvent(RegistrationSearchDTO $dto, Event $event): Collection
    {
        $query = $this->createQueryBuilder('t')
            ->join(Member::class, 'm', Join::WITH, 't.id = m.team')
            ->where('t.event = :event')
            ->andWhere('t.constructions IS NOT EMPTY')
            ->setParameter('event', $event)
            ->orderBy('t.name', 'ASC');
        if ($dto->getTeamNameOrIdentifier()) {
            $query->andWhere('(t.name LIKE :name1 OR t.identifier = :name2)')
                ->setParameter('name1', "%{$dto->getTeamNameOrIdentifier()}%")
                ->setParameter('name2', $dto->getTeamNameOrIdentifier());
        }
        if ($dto->getMemberSurname()) {
            $query->andWhere('m.surname LIKE :surname')
                ->setParameter('surname', "%{$dto->getMemberSurname()}%");
        }

        return new ArrayCollection($query->getQuery()->execute());
    }

    public function save(Team $team): void
    {
        $this->getEntityManager()->persist($team);
        $this->getEntityManager()->flush();
    }
}
