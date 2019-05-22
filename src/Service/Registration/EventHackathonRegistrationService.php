<?php declare(strict_types=1);

namespace BalticRobo\Website\Service\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Hackathon\Member;
use BalticRobo\Website\Entity\Registration\Hackathon\Team;
use BalticRobo\Website\Model\Judge\RegistrationSearchDTO;
use BalticRobo\Website\Repository\Registration\Hackathon\MemberRepository;
use BalticRobo\Website\Repository\Registration\Hackathon\TeamRepository;
use Doctrine\Common\Collections\Collection;

class EventHackathonRegistrationService
{
    private $teamRepository;
    private $memberRepository;

    public function __construct(TeamRepository $teamRepository, MemberRepository $memberRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->memberRepository = $memberRepository;
    }

    public function getTeamsByEventWithFilter(RegistrationSearchDTO $dto, Event $event): Collection
    {
        return $this->teamRepository->getFilteredByEvent($dto, $event);
    }

    public function getTeamByName(string $name, Event $event): Team
    {
        return $this->teamRepository->getByEventAndName($event, $name);
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
}
