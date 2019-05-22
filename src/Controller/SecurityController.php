<?php declare(strict_types=1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Exception\User\InvalidTokenException;
use BalticRobo\Website\Exception\User\TokenPeriodValidException;
use BalticRobo\Website\Exception\User\UserAlreadyActivatedException;
use BalticRobo\Website\Exception\User\UserNotActivatedException;
use BalticRobo\Website\Exception\User\UserNotFoundException;
use BalticRobo\Website\Form\User\UserEmailType;
use BalticRobo\Website\Form\User\UserLoginType;
use BalticRobo\Website\Form\User\UserRegisterType;
use BalticRobo\Website\Form\User\UserResetPasswordType;
use BalticRobo\Website\Model\Newsletter\NewsletterEmailDTO;
use BalticRobo\Website\Model\User\UserLoginDTO;
use BalticRobo\Website\Model\User\UserRegisterDTO;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\NewsletterService;
use BalticRobo\Website\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/security")
 */
class SecurityController extends AbstractController
{
    private $eventService;
    private $authUtils;
    private $userService;
    private $newsletterService;

    public function __construct(
        EventService $event,
        NewsletterService $newsletter,
        UserService $userService,
        AuthenticationUtils $authUtils
    ) {
        $this->eventService = $event;
        $this->userService = $userService;
        $this->newsletterService = $newsletter;
        $this->authUtils = $authUtils;
    }

    /**
     * @Route("/login", methods={"GET", "POST"})
     *
     * @param TranslatorInterface $translator
     */
    public function loginAction(TranslatorInterface $translator): Response
    {
        $error = $this->authUtils->getLastAuthenticationError();
        $form = $this->createForm(UserLoginType::class, UserLoginDTO::createFromAuthenticationUtils($this->authUtils));
        if ($error) {
            $message = $translator->trans("security.{$error->getMessageKey()}login", [], 'validators');
            $form->get('email')->addError(new FormError($message));
        }

        return $this->render('security/login.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'form' => $form->createView(),
            'is_error' => (bool) $error,
        ]);
    }

    /**
     * @Route("/logout", methods={"GET", "POST"})
     */
    public function logoutAction(): void
    {
    }

    /**
     * @Route("/register", methods={"GET", "POST"})
     *
     * @param Request $request
     */
    public function registerAction(Request $request): Response
    {
        $form = $this->createForm(UserRegisterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserRegisterDTO $formData */
            $formData = $form->getData();
            $now = new \DateTimeImmutable();
            $email = $formData->getEmail();
            $this->userService->add($formData, $now);
            if ($formData->isNewsletterAndMarketing() && !$this->newsletterService->isOptedInByEmail($email)) {
                $dto = new NewsletterEmailDTO();
                $dto->setEmail($email);
                $this->newsletterService->optIn($dto, $now);
            }
            $request->getSession()->set('registered_email', $email);

            return $this->redirectToRoute('balticrobo_website_security_registersuccess');
        }

        return $this->render('security/register.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/success", methods={"GET"})
     *
     * @param Request $request
     */
    public function registerSuccessAction(Request $request): Response
    {
        $email = $request->getSession()->get('registered_email');
        if (!$email) {
            return $this->redirectToRoute('balticrobo_website_default_home');
        }
        $request->getSession()->set('registered_email', null);

        return $this->render('security/register_success.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'email' => $email,
        ]);
    }

    /**
     * @Route("/activate/{token}", requirements={"token": "[0-9a-f]{32}"}, methods={"GET"})
     *
     * @param string $token
     */
    public function activateAction(string $token): Response
    {
        try {
            $user = $this->userService->getByToken($token);
            $this->userService->activate($user);
        } catch (UserAlreadyActivatedException $e) {
            $success = false;
            $message = $e->getMessage();
        } catch (InvalidTokenException $e) {
            if (isset($user)) {
                return $this->redirectToRoute('balticrobo_website_security_recreatetoken', [
                    'email' => $user->getEmail(),
                ]);
            }
            $success = false;
            $message = $e->getMessage();
        }

        return $this->render('security/activate.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'success' => $success ?? true,
            'message' => $message ?? '',
        ]);
    }

    /**
     * @Route("/token/{email}/recreate", methods={"GET"})
     * TODO: This action is dispatched when User tries to activate account after token validity period expires,
     *       refactor it!
     *
     * @param string $email
     */
    public function recreateTokenAction(string $email): Response
    {
        try {
            $user = $this->userService->getByEmail($email);
            $this->userService->recreateActivationToken($user, new \DateTimeImmutable());
        } catch (UserNotFoundException | UserAlreadyActivatedException | TokenPeriodValidException $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return $this->render('security/resend_validation_token.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'success' => $success ?? true,
            'message' => $message ?? '',
        ]);
    }

    /**
     * @Route("/forgotten-password/request", methods={"GET", "POST"})
     *
     * @param Request $request
     */
    public function requestForgottenPasswordAction(Request $request): Response
    {
        $form = $this->createForm(UserEmailType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $this->userService->getByEmail($form->getData()->getEmail());
                $this->userService->prepareToResetPassword($user, new \DateTimeImmutable());
            } catch (UserNotFoundException | UserNotActivatedException $e) {
                $request->getSession()->set('forgotten_password_exception', $e->getMessage());
            }
            $request->getSession()->set('forgotten_password_email', $form->getData()->getEmail());

            return $this->redirectToRoute('balticrobo_website_security_forgottenpasswordsuccess');
        }

        return $this->render('security/request_forgotten_password.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/forgotten-password/success", methods={"GET"})
     *
     * @param Request $request
     */
    public function forgottenPasswordSuccessAction(Request $request): Response
    {
        $email = $request->getSession()->get('forgotten_password_email');
        if (!$email) {
            return $this->redirectToRoute('balticrobo_website_default_home');
        }
        $request->getSession()->remove('forgotten_password_email');

        $exception = null;
        if ($request->getSession()->has('forgotten_password_exception')) {
            $exception = $request->getSession()->get('forgotten_password_exception');
            $request->getSession()->remove('forgotten_password_exception');
        }

        return $this->render('security/forgotten_password_success.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'email' => $email,
            'exception' => $exception,
        ]);
    }

    /**
     * @Route("/forgotten-password/{token}/reset", requirements={"token": "[0-9a-f]{32}"}, methods={"GET", "POST"})
     *
     * @param Request $request
     * @param string  $token
     */
    public function resetForgottenPasswordAction(Request $request, string $token): Response
    {
        try {
            $user = $this->userService->getByToken($token);
        } catch (InvalidTokenException $e) {
            $request->getSession()->set('forgotten_password_exception', $e->getMessage());
            $request->getSession()->set('forgotten_password_email', 'noreply@example.com');

            return $this->redirectToRoute('balticrobo_website_security_forgottenpasswordsuccess');
        }
        $form = $this->createForm(UserResetPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->userService->resetPassword($user, $form->getData());
            } catch (UserNotActivatedException | InvalidTokenException $e) {
                $request->getSession()->set('forgotten_password_exception', $e->getMessage());
                $request->getSession()->set('forgotten_password_email', $user->getEmail());

                return $this->redirectToRoute('balticrobo_website_security_forgottenpasswordsuccess');
            }
            $request->getSession()->set(Security::LAST_USERNAME, $user->getEmail());

            return $this->redirectToRoute('balticrobo_website_security_login');
        }

        return $this->render('security/reset_forgotten_password.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'form' => $form->createView(),
        ]);
    }
}
