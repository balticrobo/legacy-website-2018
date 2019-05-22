<?php declare(strict_types=1);

namespace BalticRobo\Website\Repository\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Volunteer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\RegistryInterface;

final class VolunteerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Volunteer::class);
    }

    public function getById(int $id): Volunteer
    {
        $record = $this->find($id);
        if (!$record) {
            throw new \Exception(); // TODO: Set correct Exception
        }

        return $record;
    }

    public function getByEvent(Event $event): Collection
    {
        $records = $this->findBy(['event' => $event]);

        return new ArrayCollection($records);
    }

    public function save(Volunteer $volunteer): void
    {
        $this->getEntityManager()->persist($volunteer);
        $this->getEntityManager()->flush();
    }

    public function update(Volunteer $volunteer): void
    {
        $this->getEntityManager()->merge($volunteer);
        $this->getEntityManager()->flush();
    }
}
