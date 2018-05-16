<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\FormValidation;

use BalticRobo\Website\Model\Registration\Competition;
use BalticRobo\Website\Model\Registration\Hackathon;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\CompetitionService;
use BalticRobo\Website\Service\Registration\HackathonService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TeamExistsValidator extends ConstraintValidator
{
    private $event;
    private $competitionService;
    private $hackathonService;

    public function __construct(EventService $event, CompetitionService $competition, HackathonService $hackathon)
    {
        $this->event = $event->getCurrentEvent();
        $this->competitionService = $competition;
        $this->hackathonService = $hackathon;
    }

    public function validate($value, Constraint $constraint): void
    {
        // TODO: Refactor it
        if ($value) {
            switch ($this->context->getClassName()) {
                case Competition\AddTeamDTO::class:
                    $test = $this->competitionService->isTeamNotExistsInEvent($value, $this->event);
                    break;
                case Hackathon\AddTeamDTO::class:
                    $test = $this->hackathonService->isTeamNotExistsInEvent($value, $this->event);
                    break;
                default:
                    $test = true;
            }
        } else {
            $test = false;
        }

        if ($test) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
