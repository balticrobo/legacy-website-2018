<?php declare(strict_types=1);

namespace BalticRobo\Website\Repository\Registration\Competition;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Competition\Member;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MemberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Member::class);
    }

    public function getById(int $id): Member
    {
        $record = $this->find($id);
        if (!$record) {
            throw new \Exception(); // TODO: Throw correct exception
        }

        return $record;
    }

    public function getByEvent(Event $event): Collection
    {
        $query = $this->createQueryBuilder('m')
            ->join(Team::class, 't', Join::WITH, 'm.team = t.id')
            ->where('t.event = :event')
            ->andWhere('t.constructions IS NOT EMPTY')
            ->setParameter('event', $event)
            ->orderBy('m.surname', 'ASC');

        return new ArrayCollection($query->getQuery()->execute());
    }

    public function save(Member $member): void
    {
        $this->getEntityManager()->persist($member);
        $this->getEntityManager()->flush();
    }
}
