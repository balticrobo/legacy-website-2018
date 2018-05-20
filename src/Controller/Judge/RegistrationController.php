<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Judge;

use BalticRobo\Website\Entity\Registration\Competition\Team;
use BalticRobo\Website\Form\Judge\RegisterTeamType;
use BalticRobo\Website\Form\Judge\RegistrationSearchType;
use BalticRobo\Website\Model\Judge\RegisterTeamDTO;
use BalticRobo\Website\Model\Judge\RegistrationSearchDTO;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\EventRegistrationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/judge/registration")
 * @Security("has_role('ROLE_JUDGE_REGISTRATION')")
 */
class RegistrationController extends Controller
{
    private $eventService;
    private $eventRegistrationService;

    public function __construct(EventService $event, EventRegistrationService $eventRegistration)
    {
        $this->eventService = $event;
        $this->eventRegistrationService = $eventRegistration;
    }

    /**
     * @Route
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return Response
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

        return $this->render('judge/registration/list.html.twig', [
            'event' => $event,
            'search' => $search->createView(),
            'query' => $searchQuery,
            'records' => $records,
        ]);
    }

    /**
     * @Route("/{identifier}", requirements={"identifier" = "\w{2,4}"})
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param string  $identifier
     *
     * @return Response
     */
    public function detailsAction(Request $request, string $identifier): Response
    {
        $event = $this->eventService->getCurrentEvent();
        $team = $this->eventRegistrationService->getTeamByIdentifier($identifier, $event);

        $form = $this->createForm(RegisterTeamType::class, RegisterTeamDTO::createFromTeamEntity($team));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            dump($form->getData());
        }

        return $this->render('judge/registration/details.html.twig', [
            'event' => $event,
            'team' => $team,
            'members' => $team->getMembers(),
            'constructions' => $team->getConstructions(),
            'form' => $form->createView(),
        ]);
    }
}
