<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\PartnerService;
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
     * @param PartnerService $service
     *
     * @return Response
     */
    public function partnersAction(PartnerService $service): Response
    {
        $event = $this->eventService->getCurrentEvent();

        return $this->render('default/partners.html.twig', [
            'records' => $service->getForEvent($event),
        ]);
    }
}
