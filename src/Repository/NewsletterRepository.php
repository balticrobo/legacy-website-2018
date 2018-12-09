<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository;

use BalticRobo\Website\Entity\Newsletter\Newsletter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NewsletterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Newsletter::class);
    }

    public function isOptedIn(string $email): bool
    {
        return 0 !== $this->count(['email' => $email]);
    }

    public function save(Newsletter $newsletter): void
    {
        $this->getEntityManager()->persist($newsletter);
        $this->getEntityManager()->flush();
    }
}
