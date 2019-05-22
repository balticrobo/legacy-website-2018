<?php declare(strict_types=1);

namespace BalticRobo\Website\Controller\Competitor\Registration;

use BalticRobo\Website\Entity\Registration\Competition\Team;
use BalticRobo\Website\Form\Registration\Competition\AddConstructionType;
use BalticRobo\Website\Form\Registration\Competition\AddMemberType;
use BalticRobo\Website\Form\Registration\Competition\AddTeamType;
use BalticRobo\Website\Form\Registration\Competition\EditConstructionType;
use BalticRobo\Website\Model\Registration\Competition\EditConstructionDTO;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\CompetitionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/competitor-zone/registration/competition")
 * @Security("has_role('ROLE_COMPETITOR')")
 */
class CompetitionController extends AbstractController
{
    private $competitionService;
    private $eventService;

    public function __construct(CompetitionService $competition, EventService $event)
    {
        $this->competitionService = $competition;
        $this->eventService = $event;
    }

    /**
     * @Route("/add", methods={"GET", "POST"})
     *
     * @param Request $request
     */
    public function addTeamAction(Request $request): Response
    {
        if (!$this->eventService->isActiveRegistration(new \DateTimeImmutable(), true)) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

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
            'event' => $this->eventService->getCurrentEvent(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *     "/{eventYear}/{identifier}",
     *     requirements={"year": "\d{4}", "identifier": "\w{2,4}"},
     *     methods={"GET", "POST"}
     * )
     *
     * @param int    $eventYear
     * @param string $identifier
     */
    public function teamDetailsAction(int $eventYear, string $identifier): Response
    {
        $event = $this->eventService->getEventByYear($eventYear);
        $team = $this->competitionService->getTeamByIdentifierAndEvent($identifier, $event);

        return $this->render('competitor/registration/competition/team_details.html.twig', [
            'event' => $event,
            'team' => $team,
            'is_active_registration' => [
                'extended_period' => $this->eventService->isActiveRegistration(new \DateTimeImmutable(), true),
            ],
        ]);
    }

    /**
     * @Route("/{identifier}/add/member", requirements={"identifier": "\w{2,4}"}, methods={"GET", "POST"})
     *
     * @param Request $request
     * @param string  $identifier
     */
    public function addMemberAction(Request $request, string $identifier): Response
    {
        if (!$this->eventService->isActiveRegistration(new \DateTimeImmutable(), true)) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $event = $this->eventService->getCurrentEvent();
        $team = $this->competitionService->getTeamByIdentifierAndEvent($identifier, $event);

        if ($team->getMembers()->count() >= Team::MAX_MEMBERS) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $form = $this->createForm(AddMemberType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->competitionService->addMember($form->getData(), $team, new \DateTimeImmutable());

            return $this->redirectToRoute('balticrobo_website_competitor_registration_competition_teamdetails', [
                'eventYear' => $event->getYear(),
                'identifier' => $team->getIdentifier(),
            ]);
        }

        return $this->render('competitor/registration/competition/add_member.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{identifier}/add/construction", requirements={"identifier": "\w{2,4}"}, methods={"GET", "POST"})
     *
     * @param Request $request
     * @param string  $identifier
     */
    public function addConstructionAction(Request $request, string $identifier): Response
    {
        if (!$this->eventService->isActiveRegistration(new \DateTimeImmutable(), true)) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $event = $this->eventService->getCurrentEvent();
        $team = $this->competitionService->getTeamByIdentifierAndEvent($identifier, $event);

        $form = $this->createForm(AddConstructionType::class, null, ['event' => $event, 'team' => $team]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->competitionService->addConstruction($form->getData(), $team, new \DateTimeImmutable());

            return $this->redirectToRoute('balticrobo_website_competitor_registration_competition_teamdetails', [
                'eventYear' => $event->getYear(),
                'identifier' => $team->getIdentifier(),
            ]);
        }

        return $this->render('competitor/registration/competition/add_construction.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{identifier}/construction/{name}", requirements={"identifier": "\w{2,4}"}, methods={"GET", "POST"})
     *
     * @param Request $request
     * @param string  $identifier
     * @param string  $name
     */
    public function editConstructionAction(Request $request, string $identifier, string $name): Response
    {
        if (!$this->eventService->isActiveRegistration(new \DateTimeImmutable(), true)) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $event = $this->eventService->getCurrentEvent();
        $team = $this->competitionService->getTeamByIdentifierAndEvent($identifier, $event);
        $construction = $this->competitionService->getConstructionByNameAndTeam($name, $team);

        $form = $this->createForm(EditConstructionType::class, EditConstructionDTO::createFromEntity($construction), [
            'event' => $event,
            'team' => $team,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->competitionService->editConstruction($construction, $form->getData());

            return $this->redirectToRoute('balticrobo_website_competitor_registration_competition_teamdetails', [
                'eventYear' => $event->getYear(),
                'identifier' => $team->getIdentifier(),
            ]);
        }

        return $this->render('competitor/registration/competition/edit_construction.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'team' => $team,
        ]);
    }
}
