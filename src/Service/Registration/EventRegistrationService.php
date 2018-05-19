<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Model\Judge\RegistrationSearchDTO;
use BalticRobo\Website\Repository\Registration\Competition\ConstructionRepository;
use BalticRobo\Website\Repository\Registration\Competition\TeamRepository;
use Doctrine\Common\Collections\Collection;

class EventRegistrationService
{
    private $teamRepository;
    private $constructionRepository;

    public function __construct(TeamRepository $teamRepository, ConstructionRepository $constructionRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->constructionRepository = $constructionRepository;
    }

    public function getTeamsByEvent(RegistrationSearchDTO $dto, Event $event): Collection
    {
        return $this->teamRepository->getFilteredByEvent($dto, $event);
    }
}
