<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository;

use BalticRobo\Website\Entity\Storage\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, File::class);
    }

    public function getTotal(): int
    {
        return $this->count([]);
    }

    /**
     * @param int $skip
     * @param int $take
     *
     * @return Collection|File[]
     */
    public function getRecords(int $skip, int $take): Collection
    {
        return new ArrayCollection($this->findBy([], [], $take, $skip));
    }

    public function save(File $file): void
    {
        $this->getEntityManager()->persist($file);
        $this->getEntityManager()->flush();
    }
}
