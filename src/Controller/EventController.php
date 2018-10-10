<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Rule\Rule;
use BalticRobo\Website\Exception\Event\EventCompetitionNotFoundException;
use BalticRobo\Website\Exception\Event\EventnNotFoundException;
use BalticRobo\Website\Exception\Rule\RuleNotFoundException;
use BalticRobo\Website\Service\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function rulesAction(Request $request): Response
    {
        $event = $this->eventService->getCurrentEvent();
        $rules = $this->eventService->getRulesByEventAndLocale($event, $request->getLocale());
        $thisYear = true;
        if ($rules->isEmpty()) {
            $rules = $this->eventService
                ->getRulesByEventAndLocale($this->eventService->getLastEvent(), $request->getLocale());
            $thisYear = false;
        }

        return $this->render('event/rules.html.twig', [
            'event' => $event,
            'rules' => $rules,
            'archive' => !$thisYear,
        ]);
    }

    /**
     * @Route("/{eventYear}/rule/{competitionSlug}")
     * @Method("GET")
     *
     * @param Request $request
     * @param int     $eventYear
     * @param string  $competitionSlug
     *
     * @return Response
     */
    public function ruleAction(Request $request, int $eventYear, string $competitionSlug): Response
    {
        try {
            $event = $this->eventService->getEventByYear($eventYear);
            $rule = $this->eventService
                ->getRuleBySlugAndEventAndLocale($event, $competitionSlug, $request->getLocale());
        } catch (EventnNotFoundException | EventCompetitionNotFoundException | RuleNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return $this->render('event/rule.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'rule' => $rule,
            'archive' => $event !== $this->eventService->getCurrentEvent(),
        ]);
    }
}
