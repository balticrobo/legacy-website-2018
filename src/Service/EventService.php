<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Rule\Rule;
use BalticRobo\Website\Repository\EventRepository;
use BalticRobo\Website\Repository\RuleRepository;
use Doctrine\Common\Collections\Collection;

class EventService
{
    private $eventRepository;
    private $ruleRepository;

    public function __construct(EventRepository $eventRepository, RuleRepository $ruleRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->ruleRepository = $ruleRepository;
    }

    public function getCurrentRulesByLocale(string $locale): Collection
    {
        $event = $this->eventRepository->getCurrentEvent();

        return $this->ruleRepository->getCurrentRulesByLocale($event, $locale);
    }

    public function getCurrentRuleBySlugAndLocale(string $competitionSlug, string $locale): Rule
    {
        $event = $this->eventRepository->getCurrentEvent();
        $competition = $event->getCompetitionBySlug($competitionSlug);

        return $competition->getRuleByLocale($locale);
    }

    public function getCurrentEvent(): Event
    {
        return $this->eventRepository->getCurrentEvent();
    }

    public function getEventByYear(int $year): Event
    {
        return $this->eventRepository->getEventByYear($year);
    }

    public function getRulesByEvent(Event $event): Collection
    {
        return $this->ruleRepository->getRulesByEvent($event);
    }

    public function getRuleById(int $id): Rule
    {
        return $this->ruleRepository->getById($id);
    }

    public function updateRule(Rule $rule): void
    {
        $this->ruleRepository->save($rule);
    }
}
