<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Cms;

use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\VolunteerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/volunteer")
 * @Security("has_role('ROLE_CMS_USER')")
 */
final class VolunteerController extends AbstractController
{
    private $eventService;
    private $volunteerService;

    public function __construct(EventService $event, VolunteerService $volunteer)
    {
        $this->eventService = $event;
        $this->volunteerService = $volunteer;
    }

    /**
     * @Route(methods={"GET"})
     */
    public function listAction(): Response
    {
        $event = $this->eventService->getCurrentEvent();
        $records = $this->volunteerService->getByEvent($event);

        return $this->render('cms/volunteer/list.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'records' => $records,
        ]);
    }
}
