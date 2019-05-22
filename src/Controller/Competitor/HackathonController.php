<?php declare(strict_types=1);

namespace BalticRobo\Website\Controller\Competitor;

use BalticRobo\Website\Form\Registration\Hackathon\SurveyType;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\SurveyService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/competitor-zone/hackathon")
 * @Security("has_role('ROLE_COMPETITOR')")
 */
class HackathonController extends AbstractController
{
    private $surveyService;
    private $eventService;

    public function __construct(SurveyService $survey, EventService $event)
    {
        $this->surveyService = $survey;
        $this->eventService = $event;
    }

    /**
     * @Route("/survey", methods={"GET", "POST"})
     *
     * @param Request $request
     */
    public function surveyAction(Request $request): Response
    {
        $event = $this->eventService->getCurrentEvent();
        if (!$event->isActiveSurvey(new \DateTimeImmutable())
            || $this->surveyService->isHackathonSurveySent($this->getUser(), $event)) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $form = $this->createForm(SurveyType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->surveyService->saveSurvey($form->getData(), $this->getUser(), $event, new \DateTimeImmutable());

            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        return $this->render('competitor/hackathon/survey.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }
}
