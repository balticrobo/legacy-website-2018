<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository\Registration\Competition;

use BalticRobo\Website\Entity\Registration\Competition\Construction;
use BalticRobo\Website\Entity\Registration\Competition\ConstructionCompetition;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ConstructionCompetitionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConstructionCompetition::class);
    }

    public function getByTeam(Team $team): Collection
    {
        $records = $this->createQueryBuilder('cc')
            ->join(Construction::class, 'c', Join::WITH, 'cc.construction = c.id')
            ->join(Team::class, 't', Join::WITH, 'c.team = t.id')
            ->where('t = :team')
            ->setParameter('team', $team)
            ->getQuery()
            ->execute();

        return new ArrayCollection($records);
    }

    public function getByConstructionIdAndCompetitionId(
        int $constructionId,
        int $competitionId
    ): ConstructionCompetition {
        $record = $this->createQueryBuilder('cc')
            ->where('cc.construction = :construction')
            ->andWhere('cc.competition = :competition')
            ->getQuery()
            ->setParameter('construction', $constructionId)
            ->setParameter('competition', $competitionId)
            ->getSingleResult();
        if (!$record) {
            throw new \Exception(); // TODO: Throw proper exception
        }

        return $record;
    }

    public function save(ConstructionCompetition $constructionCompetition): void
    {
        $this->getEntityManager()->persist($constructionCompetition);
        $this->getEntityManager()->flush();
    }
}
