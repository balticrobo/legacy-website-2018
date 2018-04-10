<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Security;

use BalticRobo\Website\Form\User\UserLoginType;
use BalticRobo\Website\Model\User\UserLoginDTO;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class UserAuthenticator extends AbstractFormLoginAuthenticator
{
    private $formFactory;
    private $passwordEncoder;
    private $router;
    private $csrfTokenManager;

    public function __construct(
        FormFactoryInterface $formFactory,
        UserPasswordEncoderInterface $passwordEncoder,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    ) {
        $this->formFactory = $formFactory;
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function supports(Request $request): bool
    {
        return $request->getPathInfo() === $this->getLoginUrl() && $request->isMethod('POST');
    }

    public function getCredentials(Request $request): UserLoginDTO
    {
        $this->validateCsrfToken($request->request->get('user_login')['_token']);
        $credentials = $this->formFactory->create(UserLoginType::class)->handleRequest($request)->getData();
        $request->getSession()->set(Security::LAST_USERNAME, $credentials->getEmail());

        return $credentials;
    }

    /**
     * @param UserLoginDTO          $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
    {
        return $userProvider->loadUserByUsername($credentials->getEmail());
    }

    /**
     * @param UserLoginDTO  $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials->getPassword());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): ?Response
    {
        return new RedirectResponse($this->getTargetRedirectUrl($request) ?? $this->getDefaultTargetRedirectUrl());
    }

    public function supportsRememberMe(): bool
    {
        return true;
    }

    protected function getLoginUrl(): string
    {
        return $this->router->generate('balticrobo_website_security_login');
    }

    protected function getTargetRedirectUrl(Request $request): ?string
    {
        return $request->getSession()->get('_security.app_web.target_path');
    }

    protected function getDefaultTargetRedirectUrl(): string
    {
        // TODO: Change this
        return $this->router->generate('balticrobo_website_default_home');
    }

    private function validateCsrfToken(string $token): void
    {
        if (!$this->csrfTokenManager->isTokenValid(new CsrfToken('user_login', $token))) {
            throw new InvalidCsrfTokenException();
        }
    }
}
