<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\FormValidation;

use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\CompetitionService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TeamExistsValidator extends ConstraintValidator
{
    private $event;
    private $competitionService;

    public function __construct(EventService $eventService, CompetitionService $competitionService)
    {
        $this->event = $eventService->getCurrentEvent();
        $this->competitionService = $competitionService;
    }

    public function validate($value, Constraint $constraint): void
    {
        if ($value && $this->competitionService->isTeamNotExistsInEvent($value, $this->event)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
