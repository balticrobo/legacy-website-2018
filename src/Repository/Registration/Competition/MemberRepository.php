<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository\Registration\Competition;

use BalticRobo\Website\Entity\Registration\Competition\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function save(Member $member): void
    {
        $this->getEntityManager()->persist($member);
        $this->getEntityManager()->flush();
    }
}
