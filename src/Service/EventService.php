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

    public function getRulesByEventAndLocale(Event $event, string $locale): Collection
    {
        return $this->ruleRepository->getRulesByEventAndLocale($event, $locale);
    }

    public function getRuleBySlugAndEventAndLocale(Event $event, string $competitionSlug, string $locale): Rule
    {
        $competition = $event->getCompetitionBySlug($competitionSlug);

        return $competition->getRuleByLocale($locale);
    }

    public function getCurrentEvent(): Event
    {
        return $this->eventRepository->getCurrentEvent();
    }

    public function getLastEvent(): Event
    {
        return $this->eventRepository->getLastEvent();
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

    public function isActiveRegistration(\DateTimeImmutable $now, bool $withExtendedPeriod = false): bool
    {
        $event = $this->getCurrentEvent();
        if ($withExtendedPeriod) {
            return $event->isActiveRegistration($now) || $event->isActiveRegistrationAgain($now);
        }

        return $event->isActiveRegistration($now);
    }
}
