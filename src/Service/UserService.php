<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Exception\User\UserNotFoundException;
use BalticRobo\Website\Model\User\UserRegisterDTO;
use BalticRobo\Website\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $userRepository;
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function isRegisteredUser(string $email): bool
    {
        try {
            $this->userRepository->getByEmail($email);
        } catch (UserNotFoundException $e) {
            return false;
        }

        return true;
    }

    public function add(UserRegisterDTO $dto, \DateTimeImmutable $now): void
    {
        $user = User::createFromRegisterDTO($dto, $now);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        $this->userRepository->save($user);
        // TODO: send confirmation email
    }
}
