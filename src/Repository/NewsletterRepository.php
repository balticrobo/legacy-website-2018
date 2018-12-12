<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository;

use BalticRobo\Website\Entity\Newsletter\Newsletter;
use BalticRobo\Website\Exception\Newsletter\NewsletterNotFoundException;
use BalticRobo\Website\Model\Newsletter\NewsletterIdDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NewsletterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Newsletter::class);
    }

    public function getById(NewsletterIdDTO $dto): Newsletter
    {
        $record = $this->findOneBy(['id' => $dto->getId()]);
        if (!$record) {
            throw new NewsletterNotFoundException();
        }

        return $record;
    }

    public function isOptedIn(string $email): bool
    {
        return 0 !== $this->count(['email' => $email]);
    }

    public function isRegisteredForNewsletter(NewsletterIdDTO $dto): bool
    {
        return 0 !== $this->count(['id' => $dto->getId()]);
    }

    public function save(Newsletter $newsletter): void
    {
        $this->getEntityManager()->persist($newsletter);
        $this->getEntityManager()->flush();
    }

    public function remove(Newsletter $newsletter): void
    {
        $this->getEntityManager()->remove($newsletter);
        $this->getEntityManager()->flush();
    }
}
