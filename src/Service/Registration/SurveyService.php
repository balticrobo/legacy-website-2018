<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service\Registration;

use BalticRobo\Website\Adapter\DoctrineEnum\RegistrationTypeEnum;
use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Survey;
use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Model\Registration\SurveyDTO;
use BalticRobo\Website\Repository\Registration\SurveyRepository;

class SurveyService
{
    private $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function isCompetitionSurveySent(User $user, Event $event): bool
    {
        return $this->surveyRepository->isSent($user, RegistrationTypeEnum::COMPETITION, $event);
    }

    public function isHackathonSurveySent(User $user, Event $event): bool
    {
        return $this->surveyRepository->isSent($user, RegistrationTypeEnum::HACKATHON, $event);
    }

    public function saveSurvey(SurveyDTO $dto, User $user, Event $event, \DateTimeImmutable $now): void
    {
        $survey = Survey::createFromDTO($dto, $event, $user, $now);
        $this->surveyRepository->save($survey);
    }
}
