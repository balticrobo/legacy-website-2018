<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/special-events")
 */
class SpecialEventsController extends AbstractController
{
    private $eventService;

    public function __construct(EventService $event)
    {
        $this->eventService = $event;
    }

    /**
     * It's for 2018 event.
     * Also 2019 event.
     *
     * @Route("/for-kids", methods={"GET"})
     */
    public function forKidsAction(): Response
    {
        return $this->render('special_events/for_kids.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }
}
