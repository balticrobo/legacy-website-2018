<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Competition\ConstructionCompetition;
use BalticRobo\Website\Entity\Registration\Competition\Member;
use BalticRobo\Website\Entity\Registration\Competition\Team;
use BalticRobo\Website\Model\Judge\RegistrationSearchDTO;
use BalticRobo\Website\Repository\Registration\Competition\ConstructionCompetitionRepository;
use BalticRobo\Website\Repository\Registration\Competition\ConstructionRepository;
use BalticRobo\Website\Repository\Registration\Competition\MemberRepository;
use BalticRobo\Website\Repository\Registration\Competition\TeamRepository;
use Doctrine\Common\Collections\Collection;

class EventCompetitionRegistrationService
{
    private $teamRepository;
    private $constructionRepository;
    private $constructionCompetitionRepository;
    private $memberRepository;

    public function __construct(
        TeamRepository $teamRepository,
        ConstructionRepository $constructionRepository,
        ConstructionCompetitionRepository $constructionCompetitionRepository,
        MemberRepository $memberRepository
    ) {
        $this->teamRepository = $teamRepository;
        $this->constructionRepository = $constructionRepository;
        $this->constructionCompetitionRepository = $constructionCompetitionRepository;
        $this->memberRepository = $memberRepository;
    }

    public function getTeamsByEvent(RegistrationSearchDTO $dto, Event $event): Collection
    {
        return $this->teamRepository->getFilteredByEvent($dto, $event);
    }

    public function getTeamByIdentifier(string $identifier, Event $event): Team
    {
        return $this->teamRepository->getByIdentifierAndEvent($identifier, $event);
    }

    public function getConstructionsByTeam(Team $team): Collection
    {
        return $this->constructionCompetitionRepository->getByTeam($team);
    }

    public function getMemberById(int $id): Member
    {
        return $this->memberRepository->getById($id);
    }

    public function setMember(Member $member, string $action, \DateTimeImmutable $now): void
    {
        // TODO: Refactor
        switch ($action) {
            case 'presence':
                $member = Member::editFromRegisterTeam($member, true, false, $now);
                break;
            case 'shirt_given':
                $member = Member::editFromRegisterTeam($member, false, true, $now);
                break;
        }
        $this->memberRepository->save($member);
    }

    public function getConstructionCompetition(int $constructionId, int $competitionId): ConstructionCompetition
    {
        return $this->constructionCompetitionRepository
            ->getByConstructionIdAndCompetitionId($constructionId, $competitionId);
    }

    public function setConstructionCompetition(
        ConstructionCompetition $cc,
        string $action,
        \DateTimeImmutable $now
    ): void {
        // TODO: Refactor
        switch ($action) {
            case 'presence':
                $cc = ConstructionCompetition::editFromRegisterTeam($cc, true, false, $now);
                break;
            case 'tech_valid':
                $cc = ConstructionCompetition::editFromRegisterTeam($cc, false, true, $now);
                break;
        }
        $this->constructionCompetitionRepository->save($cc);
    }
}
