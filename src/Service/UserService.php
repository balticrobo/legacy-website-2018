<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Exception\User\InvalidTokenException;
use BalticRobo\Website\Exception\User\TokenPeriodValidException;
use BalticRobo\Website\Exception\User\UserAlreadyActivatedException;
use BalticRobo\Website\Exception\User\UserNotFoundException;
use BalticRobo\Website\Model\Mail\UserRecreatedRegistrationTokenMail;
use BalticRobo\Website\Model\Mail\UserRegisteredMail;
use BalticRobo\Website\Model\User\UserRegisterDTO;
use BalticRobo\Website\Repository\UserRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $userRepository;
    private $mailerService;
    private $passwordEncoder;
    private $router;

    public function __construct(
        UserRepository $userRepository,
        MailerService $mailerService,
        UserPasswordEncoderInterface $passwordEncoder,
        RouterInterface $router
    ) {
        $this->userRepository = $userRepository;
        $this->mailerService = $mailerService;
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
    }

    public function getByToken(string $token): User
    {
        return $this->userRepository->getByToken($token);
    }

    public function getByEmail(string $email): User
    {
        return $this->userRepository->getByEmail($email);
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
        $user = User::createFromRegisterDTO($dto, $this->generateToken(), $now);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        $this->userRepository->save($user);
        $this->mailerService->sendMail($user, new UserRegisteredMail($this->getActivationUrl($user)));
    }

    public function activate(User $user): void
    {
        if ($user->isEnabled()) {
            throw new UserAlreadyActivatedException();
        } elseif (!$user->isTokenValid($user->getToken())) {
            throw new InvalidTokenException();
        }
        $user->activate();
        $this->userRepository->save($user);
    }

    public function recreateToken(User $user, \DateTimeImmutable $now): void
    {
        if ($user->isEnabled()) {
            throw new UserAlreadyActivatedException();
        } elseif ($user->isTokenValid($user->getToken())) {
            throw new TokenPeriodValidException();
        }

        $user->setToken($this->generateToken(), $now);
        $this->userRepository->save($user);
        // TODO: Create email content
        $this->mailerService->sendMail($user, new UserRecreatedRegistrationTokenMail($this->getActivationUrl($user)));
    }

    private function generateToken(): string
    {
        return md5(random_bytes(32));
    }

    private function getActivationUrl(User $user): string
    {
        return $this->router->generate('balticrobo_website_security_activate', [
            'token' => $user->getToken(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
