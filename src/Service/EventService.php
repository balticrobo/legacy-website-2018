<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

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
}
