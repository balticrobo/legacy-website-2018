<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Model\Registration\Competition\AddTeamDTO;
use BalticRobo\Website\Repository\Registration\Competition\TeamRepository;
use Doctrine\Common\Collections\Collection;

class CompetitionService
{
    private $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function getTeamByIdentifierAndEvent(string $identifier, Event $event): Team
    {
        return $this->teamRepository->getByIdentifierAndEvent($identifier, $event);
    }

    public function getTeamsForUserInEvent(User $user, Event $event): Collection
    {
        return $this->teamRepository->getByEventAndUser($event, $user);
    }

    public function addTeam(AddTeamDTO $teamDTO, Event $event, User $author, \DateTimeImmutable $now): void
    {
        $team = Team::createFromAddDTO($teamDTO, $event, $author, $now);
        $this->teamRepository->save($team);
    }
}
