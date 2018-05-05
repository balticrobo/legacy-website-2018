<?php

declare(strict_types = 1);

namespace BalticRobo\Website\EventListener;

use BalticRobo\Website\Repository\UserRepository;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    private $auth;
    private $router;
    private $userRepository;

    public function __construct(AuthorizationCheckerInterface $auth, RouterInterface $router, UserRepository $user)
    {
        $this->auth = $auth;
        $this->router = $router;
        $this->userRepository = $user;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $request = $event->getRequest();
        if ($this->auth->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($request->getRequestUri() === $this->router->generate('balticrobo_website_security_login')) {
                $user = $event->getAuthenticationToken()->getUser();
                $user->setLastLoginAt(new \DateTimeImmutable());
                $this->userRepository->save($user);
            }
        }
    }
}
