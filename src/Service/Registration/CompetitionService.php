<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Competition\Construction;
use BalticRobo\Website\Entity\Registration\Competition\Member;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Model\Registration\Competition\AddConstructionDTO;
use BalticRobo\Website\Model\Registration\Competition\AddMemberDTO;
use BalticRobo\Website\Model\Registration\Competition\AddTeamDTO;
use BalticRobo\Website\Repository\Registration\Competition\TeamRepository;
use Doctrine\Common\Collections\Collection;

class CompetitionService
{
    private $teamRepository;

    public function __construct(TeamRepository $team)
    {
        $this->teamRepository = $team;
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

    public function addMember(AddMemberDTO $memberDTO, Team $team, \DateTimeImmutable $now): void
    {
        $member = Member::createFromAddDTO($memberDTO, $team, $now);
        $team->addMember($member);
        $this->teamRepository->save($team);
    }

    public function addConstruction(AddConstructionDTO $constructionDTO, Team $team, \DateTimeImmutable $now): void
    {
        $construction = Construction::createFromAddDTO($constructionDTO, $team, $now);
        $team->addConstruction($construction);
        $this->teamRepository->save($team);
    }
}
