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
     * @Route("/user/login")
     * @Method({"GET", "POST"})
     */
    public function userLoginAction(): Response
    {
        $dto = new UserLoginDTO();
        $dto->setUsername($this->authUtils->getLastUsername());

        $form = $this->createForm(UserLoginType::class, $dto);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $this->authUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/user/logout")
     * @Method({"GET", "POST"})
     */
    public function userLogoutAction(): void
    {
    }
}
