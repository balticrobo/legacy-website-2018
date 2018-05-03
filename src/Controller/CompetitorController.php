<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\CompetitionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/competitor-zone")
 * @Security("has_role('ROLE_COMPETITOR')")
 */
class CompetitorController extends Controller
{
    private $eventService;
    private $competitionService;

    public function __construct(EventService $eventService, CompetitionService $competitionService)
    {
        $this->eventService = $eventService;
        $this->competitionService = $competitionService;
    }

    /**
     * @Route
     * @Method("GET")
     *
     * @return Response
     */
    public function dashboardAction(): Response
    {
        $event = $this->eventService->getCurrentEvent();
        $competitionTeams = $this->competitionService->getTeamsForUserInEvent($this->getUser(), $event);

        return $this->render('competitor/dashboard.html.twig', [
            'competition_teams' => $competitionTeams,
            'competitor' => $this->getUser(),
            'event' => $event,
        ]);
    }
}
