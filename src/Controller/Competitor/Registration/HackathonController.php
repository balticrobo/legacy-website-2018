<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Competitor\Registration;

use BalticRobo\Website\Entity\Registration\Hackathon\Team;
use BalticRobo\Website\Form\Registration\Hackathon\AddMemberType;
use BalticRobo\Website\Form\Registration\Hackathon\AddTeamType;
use BalticRobo\Website\Form\Registration\Hackathon\SurveyType;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\HackathonService;
use BalticRobo\Website\Service\Registration\SurveyService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/competitor-zone/registration/hackathon")
 * @Security("has_role('ROLE_COMPETITOR')")
 */
class HackathonController extends Controller
{
    private $hackathonService;
    private $surveyService;
    private $eventService;

    public function __construct(HackathonService $hackathon, SurveyService $survey, EventService $event)
    {
        $this->hackathonService = $hackathon;
        $this->surveyService = $survey;
        $this->eventService = $event;
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
        if (!$this->eventService->isActiveRegistration(new \DateTimeImmutable())) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $event = $this->eventService->getCurrentEvent();
        $teams = $this->hackathonService->getTeamsForUserInEvent($this->getUser(), $event);

        if ($teams->count() >= Team::MAX_TEAMS) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $form = $this->createForm(AddTeamType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->hackathonService->addTeam(
                $form->getData(),
                $this->eventService->getCurrentEvent(),
                $this->getUser(),
                new \DateTimeImmutable()
            );

            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        return $this->render('competitor/registration/hackathon/add_team.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{eventYear}/{name}", requirements={"year" = "\d{4}"})
     * @Method({"GET", "POST"})
     *
     * @param int    $eventYear
     * @param string $name
     *
     * @return Response
     */
    public function teamDetailsAction(int $eventYear, string $name): Response
    {
        $event = $this->eventService->getEventByYear($eventYear);
        $team = $this->hackathonService->getTeamByNameAndEvent($name, $event);

        return $this->render('competitor/registration/hackathon/team_details.html.twig', [
            'event' => $event,
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{name}/add/member")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param string  $name
     *
     * @return Response
     */
    public function addMemberAction(Request $request, string $name): Response
    {
        if (!$this->eventService->isActiveRegistration(new \DateTimeImmutable())) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $event = $this->eventService->getCurrentEvent();
        $team = $this->hackathonService->getTeamByNameAndEvent($name, $event);

        if ($team->getMembers()->count() >= Team::MAX_MEMBERS) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $form = $this->createForm(AddMemberType::class, null, ['team_have_captain' => (bool) $team->getCaptain()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->hackathonService->addMember($form->getData(), $team, new \DateTimeImmutable());

            return $this->redirectToRoute('balticrobo_website_competitor_registration_hackathon_teamdetails', [
                'eventYear' => $event->getYear(),
                'name' => $team->getName(),
            ]);
        }

        return $this->render('competitor/registration/hackathon/add_member.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'team' => $team,
        ]);
    }

    /**
     * @Route("/survey")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function surveyAction(Request $request): Response
    {
        $event = $this->eventService->getCurrentEvent();
        if (!$event->isActiveSurvey(new \DateTimeImmutable())
            || $this->surveyService->isHackathonSurveySent($this->getUser(), $event)) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $form = $this->createForm(SurveyType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->surveyService->saveSurvey($form->getData(), $this->getUser(), $event, new \DateTimeImmutable());

            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        return $this->render('competitor/registration/competition/survey.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }
}
