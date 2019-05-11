<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Hackathon\Member;
use BalticRobo\Website\Entity\Registration\Hackathon\Team;
use BalticRobo\Website\Entity\User\User;
use BalticRobo\Website\Model\Registration\Hackathon\AddMemberDTO;
use BalticRobo\Website\Model\Registration\Hackathon\AddTeamDTO;
use BalticRobo\Website\Repository\Registration\Hackathon\TeamRepository;
use Doctrine\Common\Collections\Collection;

class HackathonService
{
    private $teamRepository;

    public function __construct(TeamRepository $team)
    {
        $this->teamRepository = $team;
    }

    public function isTeamNotExistsInEvent(string $name, Event $event): bool
    {
        try {
            $this->teamRepository->getByEventAndName($event, $name);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function getTeamById(int $id): Team
    {
        return $this->teamRepository->getById($id);
    }

    public function getTeamsByEvent(Event $event): Collection
    {
        return $this->teamRepository->getByEvent($event);
    }

    public function getTeamsForUserInEvent(User $user, Event $event): Collection
    {
        return $this->teamRepository->getByEventAndUser($event, $user);
    }

    public function getTeamByNameAndEvent(string $name, Event $event): Team
    {
        return $this->teamRepository->getByEventAndName($event, $name);
    }

    public function allowToStartInEvent(Team $team): void
    {
        $this->teamRepository->allowToStartInEvent($team);
    }

    public function disallowToStartInEvent(Team $team): void
    {
        $this->teamRepository->disallowToStartInEvent($team);
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
        if ($memberDTO->isCaptain()) {
            $team->setCaptain($member);
        }
        $this->teamRepository->save($team);
    }
}
