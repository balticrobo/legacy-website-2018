<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository\Registration;

use BalticRobo\Website\Entity\Registration\Volunteer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class VolunteerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Volunteer::class);
    }

    public function save(Volunteer $volunteer): void
    {
        $this->getEntityManager()->persist($volunteer);
        $this->getEntityManager()->flush();
    }
}
