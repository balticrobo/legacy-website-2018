<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Competitor\Registration;

use BalticRobo\Website\Form\Registration\Competition\AddTeamType;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\CompetitionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/competitor-zone/registration/competition")
 * @Security("has_role('ROLE_COMPETITOR')")
 */
class CompetitionController extends Controller
{
    private $competitionService;
    private $eventService;

    public function __construct(CompetitionService $competitionService, EventService $eventService)
    {
        $this->competitionService = $competitionService;
        $this->eventService = $eventService;
    }

    /**
     * @Route("/add")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function addTeamAction(Request $request): Response
    {
        $form = $this->createForm(AddTeamType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->competitionService->addTeam(
                $form->getData(),
                $this->eventService->getCurrentEvent(),
                $this->getUser(),
                new \DateTimeImmutable()
            );

            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        return $this->render('competitor/registration/competition/add_team.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{eventYear}/{identifier}", requirements={"year" = "\d{4}", "identifier" = "\w{2,4}"})
     * @Method({"GET", "POST"})
     *
     * @param int    $eventYear
     * @param string $identifier
     *
     * @return Response
     */
    public function teamDetailsAction(int $eventYear, string $identifier): Response
    {
        $event = $this->eventService->getEventByYear($eventYear);
        $team = $this->competitionService->getTeamByIdentifierAndEvent($identifier, $event);

        return $this->render('competitor/registration/competition/team_details.html.twig', [
            'event' => $event,
            'team' => $team,
        ]);
    }
}
