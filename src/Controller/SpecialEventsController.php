<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/special-events")
 */
class SpecialEventsController extends Controller
{
    /**
     * @Route("/for-kids")
     * @Method("GET")
     */
    public function forKidsAction(): Response
    {
        return $this->render('special_events/for_kids.html.twig');
    }
}
