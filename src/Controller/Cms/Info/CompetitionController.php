<?php declare(strict_types=1);

namespace BalticRobo\Website\Controller\Cms\Info;

use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\CompetitionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/info/competition")
 * @Security("has_role('ROLE_CMS_USER')")
 */
final class CompetitionController extends AbstractController
{
    private $eventService;
    private $competitionService;

    public function __construct(EventService $event, CompetitionService $competition)
    {
        $this->eventService = $event;
        $this->competitionService = $competition;
    }

    /**
     * @Route(methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('cms/info/competition/index.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }

    /**
     * @Route("/teams", methods={"GET"})
     */
    public function teams(): Response
    {
        $event = $this->eventService->getCurrentEvent();

        return $this->render('cms/info/competition/teams.html.twig', [
            'event' => $event,
            'records' => $this->competitionService->getTeamsByEvent($event),
        ]);
    }

    /**
     * @Route("/members", methods={"GET"})
     */
    public function members(): Response
    {
        $event = $this->eventService->getCurrentEvent();

        return $this->render('cms/info/competition/members.html.twig', [
            'event' => $event,
            'records' => $this->competitionService->getMembersByEvent($event),
        ]);
    }

    /**
     * @Route("/constructions", methods={"GET"})
     */
    public function constructions(): Response
    {
        $event = $this->eventService->getCurrentEvent();

        return $this->render('cms/info/competition/constructions.html.twig', [
            'event' => $event,
            'records' => $this->competitionService->getConstructionsByEvent($event),
        ]);
    }
}
