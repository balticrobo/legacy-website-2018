<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\CompetitionService;
use BalticRobo\Website\Service\Registration\HackathonService;
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
    private $hackathonService;

    public function __construct(EventService $event, CompetitionService $competition, HackathonService $hackathon)
    {
        $this->eventService = $event;
        $this->competitionService = $competition;
        $this->hackathonService = $hackathon;
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
        $hackathonTeams = $this->hackathonService->getTeamsForUserInEvent($this->getUser(), $event);

        return $this->render('competitor/dashboard.html.twig', [
            'competition_teams' => $competitionTeams,
            'competitor' => $this->getUser(),
            'event' => $event,
            'hackathon_teams' => $hackathonTeams,
        ]);
    }
}
