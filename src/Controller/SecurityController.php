<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Form\User\UserLoginType;
use BalticRobo\Website\Model\User\UserLoginDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    private $authUtils;

    public function __construct(AuthenticationUtils $authUtils)
    {
        $this->authUtils = $authUtils;
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
     */
    public function registerAction(): Response
    {
    }
}
