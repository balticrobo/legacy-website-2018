<?php declare(strict_types=1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\CompetitionService;
use BalticRobo\Website\Service\Registration\HackathonService;
use BalticRobo\Website\Service\Registration\InformationService;
use BalticRobo\Website\Service\Registration\SurveyService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/competitor-zone")
 * @Security("has_role('ROLE_COMPETITOR')")
 */
class CompetitorController extends AbstractController
{
    private $eventService;
    private $competitionService;
    private $hackathonService;
    private $informationService;
    private $surveyService;

    public function __construct(
        EventService $event,
        CompetitionService $competition,
        HackathonService $hackathon,
        InformationService $information,
        SurveyService $survey
    ) {
        $this->eventService = $event;
        $this->competitionService = $competition;
        $this->hackathonService = $hackathon;
        $this->informationService = $information;
        $this->surveyService = $survey;
    }

    /**
     * @Route(methods={"GET"})
     */
    public function dashboardAction(): Response
    {
        $event = $this->eventService->getCurrentEvent();
        $competitionTeams = $this->competitionService->getTeamsForUserInEvent($this->getUser(), $event);
        $hackathonTeams = $this->hackathonService->getTeamsForUserInEvent($this->getUser(), $event);
        $information = $this->informationService->getInformationByEvent($event);

        return $this->render('competitor/dashboard.html.twig', [
            'competition_teams' => $competitionTeams,
            'competitor' => $this->getUser(),
            'event' => $event,
            'is_active_registration' => [
                'standard_period' => $this->eventService->isActiveRegistration(new \DateTimeImmutable()),
                'extended_period' => $this->eventService->isActiveRegistration(new \DateTimeImmutable(), true),
            ],
            'is_survey' => [
                'competition' => !$this->surveyService->isCompetitionSurveySent($this->getUser(), $event)
                    && $competitionTeams->count() >= 1
                    && $event->isActiveSurvey(new \DateTimeImmutable()),
                'hackathon' => !$this->surveyService->isHackathonSurveySent($this->getUser(), $event)
                    && $hackathonTeams->count() >= 1
                    && $event->isActiveSurvey(new \DateTimeImmutable()),
            ],
            'hackathon_teams' => $hackathonTeams,
            'information' => $information,
        ]);
    }
}
