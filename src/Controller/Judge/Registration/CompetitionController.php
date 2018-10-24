<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Judge\Registration;

use BalticRobo\Website\Form\Judge\RegistrationSearchType;
use BalticRobo\Website\Model\Judge\RegistrationSearchDTO;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\EventCompetitionRegistrationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/judge/registration/competition")
 * @Security("has_role('ROLE_JUDGE')")
 */
class CompetitionController extends Controller
{
    private $eventService;
    private $eventRegistrationService;

    public function __construct(EventService $event, EventCompetitionRegistrationService $eventRegistration)
    {
        $this->eventService = $event;
        $this->eventRegistrationService = $eventRegistration;
    }

    /**
     * @Route(methods={"GET"})
     *
     * @param Request $request
     */
    public function listAction(Request $request): Response
    {
        $event = $this->eventService->getCurrentEvent();

        $searchQuery = new RegistrationSearchDTO();
        $search = $this->createForm(RegistrationSearchType::class);
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $searchQuery = $search->getData();
        }

        $records = $this->eventRegistrationService->getTeamsByEvent($searchQuery, $event);

        return $this->render('judge/registration/competition/list.html.twig', [
            'event' => $event,
            'search' => $search->createView(),
            'query' => $searchQuery,
            'records' => $records,
        ]);
    }

    /**
     * @Route("/{identifier}", requirements={"identifier" = "\w{2,4}"}, methods={"GET"})
     *
     * @param Request $request
     * @param string  $identifier
     */
    public function detailsAction(Request $request, string $identifier): Response
    {
        $event = $this->eventService->getCurrentEvent();
        $team = $this->eventRegistrationService->getTeamByIdentifier($identifier, $event);

        return $this->render('judge/registration/competition/details.html.twig', [
            'event' => $event,
            'team' => $team,
            'members' => $team->getMembers(),
            'constructions' => $this->eventRegistrationService->getConstructionsByTeam($team),
        ]);
    }

    /**
     * @Route("/accept/member/{id}/{action}", requirements={"id" = "\d+"}, methods={"POST"})
     *
     * @param int    $id
     * @param string $action
     */
    public function acceptMemberAction(int $id, string $action): Response
    {
        $member = $this->eventRegistrationService->getMemberById($id);
        $this->eventRegistrationService->setMember($member, $action, new \DateTimeImmutable());

        return $this->redirectToRoute('balticrobo_website_judge_registration_competition_details', [
            'identifier' => $member->getTeam()->getIdentifier(),
        ]);
    }

    /**
     * @Route(
     *     "/accept/construction/{id}/{competitionId}/{action}",
     *     requirements={"id" = "\d+", "competitionId" = "\d+"},
     *     methods={"POST"}
     * )
     *
     * @param int    $id
     * @param int    $competitionId
     * @param string $action
     */
    public function acceptConstructionAction(int $id, int $competitionId, string $action): Response
    {
        $construction = $this->eventRegistrationService->getConstructionCompetition($id, $competitionId);
        $this->eventRegistrationService->setConstructionCompetition($construction, $action, new \DateTimeImmutable());

        return $this->redirectToRoute('balticrobo_website_judge_registration_competition_details', [
            'identifier' => $construction->getConstruction()->getTeam()->getIdentifier(),
        ]);
    }
}
