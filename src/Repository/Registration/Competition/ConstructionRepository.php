<?php declare(strict_types=1);

namespace BalticRobo\Website\Repository\Registration\Competition;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Competition\Construction;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ConstructionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Construction::class);
    }

    public function getByNameAndTeam(string $name, Team $team): Construction
    {
        $record = $this->findOneBy(['name' => $name, 'team' => $team]);
        if (!$record) {
            throw new \Exception(); // TODO: Throw correct exception
        }

        return $record;
    }

    public function getByEvent(Event $event): Collection
    {
        $query = $this->createQueryBuilder('c')
            ->join(Team::class, 't', Join::WITH, 'c.team = t.id')
            ->where('t.event = :event')
            ->andWhere('t.constructions IS NOT EMPTY')
            ->setParameter('event', $event)
            ->orderBy('c.name', 'ASC');

        return new ArrayCollection($query->getQuery()->execute());
    }

    public function save(Construction $construction): void
    {
        $this->getEntityManager()->persist($construction);
        $this->getEntityManager()->flush();
    }
}
