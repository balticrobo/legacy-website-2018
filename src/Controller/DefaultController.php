<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route
     * @Method("GET")
     *
     * @return Response
     */
    public function homeAction(): Response
    {
        return $this->render('default/home.html.twig');
    }
}
