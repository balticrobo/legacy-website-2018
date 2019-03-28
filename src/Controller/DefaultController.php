<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\PartnerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route
 */
class DefaultController extends AbstractController
{
    private $eventService;

    public function __construct(EventService $event)
    {
        $this->eventService = $event;
    }

    /**
     * @Route(methods={"GET"})
     */
    public function homeAction(): Response
    {
        return $this->render('default/home.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }

    /**
     * @Route("/terms", methods={"GET"})
     */
    public function termsAction(): Response
    {
        return $this->render('default/terms.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }

    /**
     * @Route("/terms/gdpr", methods={"GET"})
     */
    public function gdprAction(): Response
    {
        return $this->render('default/gdpr.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }

    /**
     * @Route("/partners", methods={"GET"})
     *
     * @param PartnerService $service
     */
    public function partnersAction(PartnerService $service): Response
    {
        $thisYearEvent = $this->eventService->getCurrentEvent();
        $lastYearEvent = $this->eventService->getLastEvent();

        return $this->render('default/partners.html.twig', [
            'event' => $thisYearEvent,
            'this_year' => [
                'event' => $thisYearEvent,
                'records' => $service->getForEvent($thisYearEvent),
            ],
            'last_year' => [
                'event' => $lastYearEvent,
                'records' => $service->getForEvent($lastYearEvent),
            ],
        ]);
    }

    /**
     * @Route("/schedule", methods={"GET"})
     */
    public function scheduleAction(): Response
    {
        return $this->render('default/schedule.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }
}
