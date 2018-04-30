<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository;

use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Exception\User\InvalidTokenException;
use BalticRobo\Website\Exception\User\UserNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getByEmail(string $email): User
    {
        $user = $this->findOneBy(['email' => $email]);
        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function getByToken(string $token): User
    {
        $user = $this->findOneBy(['token' => $token]);
        if (!$user) {
            throw new InvalidTokenException();
        }

        return $user;
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
