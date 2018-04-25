<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Exception\User\InvalidTokenException;
use BalticRobo\Website\Exception\User\TokenPeriodValidException;
use BalticRobo\Website\Exception\User\UserAlreadyActivatedException;
use BalticRobo\Website\Exception\User\UserNotFoundException;
use BalticRobo\Website\Form\User\UserLoginType;
use BalticRobo\Website\Form\User\UserRegisterType;
use BalticRobo\Website\Model\User\UserLoginDTO;
use BalticRobo\Website\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Translation\TranslatorInterface;

class SecurityController extends Controller
{
    private $authUtils;
    private $userService;

    public function __construct(AuthenticationUtils $authUtils, UserService $userService)
    {
        $this->authUtils = $authUtils;
        $this->userService = $userService;
    }

    /**
     * @Route("/login")
     * @Method({"GET", "POST"})
     *
     * @param TranslatorInterface $translator
     *
     * @return Response
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
            'form' => $form->createView(),
            'is_error' => (bool) $error,
        ]);
    }

    /**
     * @Route("/logout")
     * @Method({"GET", "POST"})
     */
    public function logoutAction(): void
    {
    }

    /**
     * @Route("/register")
     * @Method({"GET", "POST"})
     *
     * @param Request          $request
     * @param SessionInterface $session
     *
     * @return Response
     */
    public function registerAction(Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(UserRegisterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->add($form->getData(), new \DateTimeImmutable());
            $session->set('registered_email', $form->getData()->getEmail());

            return $this->redirectToRoute('balticrobo_website_security_registersuccess');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/success")
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function registerSuccessAction(Request $request): Response
    {
        $email = $request->getSession()->get('registered_email');
        if (!$email) {
            return $this->redirectToRoute('balticrobo_website_default_home');
        }
        $request->getSession()->set('registered_email', null);

        return $this->render('security/register_success.html.twig', [
            'email' => $email,
        ]);
    }

    /**
     * @Route("/register/{token}/activate", requirements={"token" = "\w{32}"})
     * @Method("GET")
     *
     * @param string $token
     *
     * @return Response
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
            'success' => $success ?? true,
            'message' => $message ?? '',
        ]);
    }

    /**
     * @Route("/register/{email}/recreate-token")
     * @Method("GET")
     *
     * TODO: This action is dispatched when User tries to activate account after token validity period expires, refactor it!
     *
     * @param string $email
     *
     * @return Response
     */
    public function recreateTokenAction(string $email): Response
    {
        try {
            $user = $this->userService->getByEmail($email);
            $this->userService->recreateToken($user, new \DateTimeImmutable());
        } catch (UserNotFoundException | UserAlreadyActivatedException | TokenPeriodValidException $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return $this->render('security/resend_validation_token.html.twig', [
            'success' => $success ?? true,
            'message' => $message ?? '',
        ]);
    }
}
