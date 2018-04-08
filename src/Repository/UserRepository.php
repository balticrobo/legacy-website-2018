<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Repository;

use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Exception\User\UserNotFoundException;
use Doctrine\Common\Persistence\ObjectManager;

class UserRepository
{
    private $objectManager;
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository(User::class);
    }

    public function getByEmail(string $email): User
    {
        $user = $this->repository->findOneBy(['email' => $email]);
        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function save(User $user): void
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }
}
