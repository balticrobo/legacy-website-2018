<?php declare(strict_types=1);

namespace BalticRobo\Website\Repository;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Event\Partner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PartnerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Partner::class);
    }

    public function getTotal(): int
    {
        return $this->count([]);
    }

    /**
     * @param int $skip
     * @param int $take
     *
     * @return Collection|Partner[]
     */
    public function getRecords(int $skip, int $take): Collection
    {
        return new ArrayCollection($this->findBy([], ['type' => 'ASC', 'sortOrder' => 'DESC'], $take, $skip));
    }

    /**
     * @param Event $event
     * @param int   $type
     *
     * @return Collection|Partner[]
     */
    public function getRecordsByEventAndType(Event $event, int $type): Collection
    {
        return new ArrayCollection($this->findBy(['event' => $event, 'type' => $type], ['sortOrder' => 'DESC']));
    }

    public function save(Partner $partner): void
    {
        $this->getEntityManager()->persist($partner);
        $this->getEntityManager()->flush();
    }
}
