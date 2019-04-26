<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Cms\Registration;

use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\HackathonService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/registration/hacklathon")
 * @Security("has_role('ROLE_CMS_USER')")
 */
final class HackathonController extends AbstractController
{
    private $eventService;
    private $hackathonService;

    public function __construct(EventService $event, HackathonService $hackathon)
    {
        $this->eventService = $event;
        $this->hackathonService = $hackathon;
    }

    /**
     * @Route(methods={"GET"})
     */
    public function listAction(): Response
    {
        $event = $this->eventService->getCurrentEvent();
        $records = $this->hackathonService->getTeamsByEvent($event);

        return $this->render('cms/registration/hackathon/list.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'records' => $records,
        ]);
    }
}
