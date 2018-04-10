<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Rule\Rule;
use BalticRobo\Website\Service\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/event")
 */
class EventController extends Controller
{
    private $eventService;

    public function __construct(EventService $event)
    {
        $this->eventService = $event;
    }

    /**
     * @Route("/rules")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function ruleAction(Request $request): Response
    {
        $rules = $this->eventService->getCurrentRulesByLocale($request->getLocale());

        return $this->render('event/rule.html.twig', [
            'rules' => $rules,
        ]);
    }
}
