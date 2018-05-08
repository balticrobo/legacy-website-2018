<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository\Registration\Competition;

use BalticRobo\Website\Entity\Registration\Competition\Construction;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function save(Construction $construction): void
    {
        $this->getEntityManager()->persist($construction);
        $this->getEntityManager()->flush();
    }
}
