<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route
     * @Method("GET")
     *
     * @return Response
     */
    public function dashboardAction(): Response
    {
        return $this->render('cms/dashboard.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }
}
