<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms")
 * @Security("has_role('ROLE_CMS_USER')")
 */
class CmsController extends Controller
{
    private $eventService;

    public function __construct(EventService $event)
    {
        $this->eventService = $event;
    }

    /**
     * @Route(methods={"GET"})
     */
    public function dashboardAction(): Response
    {
        return $this->render('cms/dashboard.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }
}
