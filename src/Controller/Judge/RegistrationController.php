<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Judge;

use BalticRobo\Website\Form\Judge\RegistrationSearchType;
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
}
