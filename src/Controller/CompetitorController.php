<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/competitor-zone")
 */
class CompetitorController extends Controller
{
    /**
     * @Route
     * @Method("GET")
     * @Security("has_role('ROLE_COMPETITOR')")
     *
     * @return Response
     */
    public function dashboardAction(): Response
    {
        return $this->render('competitor/dashboard.html.twig');
    }
}
