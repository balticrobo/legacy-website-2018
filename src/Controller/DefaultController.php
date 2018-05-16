<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    private $eventService;

    public function __construct(EventService $event)
    {
        $this->eventService = $event;
    }

    /**
     * @Route
     * @Method("GET")
     *
     * @return Response
     */
    public function homeAction(): Response
    {
        return $this->render('default/home.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }

    /**
     * @Route("/terms")
     * @Method("GET")
     *
     * @return Response
     */
    public function termsAction(): Response
    {
        return $this->render('default/terms.html.twig');
    }

    /**
     * @Route("/partners")
     * @Method("GET")
     *
     * @return Response
     */
    public function partnersAction(): Response
    {
        return $this->render('default/partners.html.twig');
    }
}
