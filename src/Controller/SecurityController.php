<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Form\User\UserLoginType;
use BalticRobo\Website\Form\User\UserRegisterType;
use BalticRobo\Website\Model\User\UserLoginDTO;
use BalticRobo\Website\Service\User\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
     * @return Response
     */
    public function loginAction(): Response
    {
        $form = $this->createForm(UserLoginType::class, UserLoginDTO::createFromAuthenticationUtils($this->authUtils));

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $this->authUtils->getLastAuthenticationError(),
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
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Request $request): Response
    {
        $form = $this->createForm(UserRegisterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->add($form->getData(), new \DateTimeImmutable());

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
     * @return Response
     */
    public function registerSuccessAction(): Response
    {
        return $this->render('security/register_success.html.twig');
    }
}
