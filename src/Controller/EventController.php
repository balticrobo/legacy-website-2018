<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Rule\Rule;
use BalticRobo\Website\Exception\Event\EventCompetitionNotFoundException;
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
        $rules = $this->eventService->getCurrentRulesByLocale($request->getLocale());

        return $this->render('event/rules.html.twig', [
            'rules' => $rules,
        ]);
    }

    /**
     * @Route("/rule/{competitionSlug}")
     * @Method("GET")
     *
     * @param Request $request
     * @param string  $competitionSlug
     *
     * @return Response
     */
    public function ruleAction(Request $request, string $competitionSlug): Response
    {
        try {
            $rule = $this->eventService->getCurrentRuleBySlugAndLocale($competitionSlug, $request->getLocale());
        } catch (EventCompetitionNotFoundException | RuleNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return $this->render('event/rule.html.twig', [
            'rule' => $rule,
        ]);
    }
}
