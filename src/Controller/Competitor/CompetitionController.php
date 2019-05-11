<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Competitor;

use BalticRobo\Website\Form\Registration\Competition\SurveyType;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\EventCompetitionRegistrationService;
use BalticRobo\Website\Service\Registration\SurveyService;
use Cocur\Slugify\Slugify;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/competitor-zone/competition")
 * @Security("has_role('ROLE_COMPETITOR')")
 */
class CompetitionController extends AbstractController
{
    private $eventCompetitionRegistrationService;
    private $surveyService;
    private $eventService;

    public function __construct(EventCompetitionRegistrationService $member, SurveyService $survey, EventService $event)
    {
        $this->eventCompetitionRegistrationService = $member;
        $this->surveyService = $survey;
        $this->eventService = $event;
    }

    /**
     * @Route("/member/{id}/guardian_consent", methods="GET")
     *
     * @param int $id
     */
    public function getGuardianConsentAction(int $id): Response
    {
        $member = $this->eventCompetitionRegistrationService->getMemberById($id);
        if (!$this->eventCompetitionRegistrationService->isMemberBelongsToUserAccount($member, $this->getUser())) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }
        $slugify = new Slugify(['lowercase' => false]);
        $filename = "BBR Guardian consent ({$slugify->slugify($member->getName(), ' ')})";

        $options = new Options();
        $options->setIsHtml5ParserEnabled(true);
        $dompdf = new Dompdf($options);
        $html = $this->renderView('_pdf/competitor/competition/guardian_consent.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'member' => $member,
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $response = new Response($dompdf->output());
        $disposition = $response->headers
            ->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, "{$filename}.pdf");
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
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
            || $this->surveyService->isCompetitionSurveySent($this->getUser(), $event)) {
            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        $form = $this->createForm(SurveyType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->surveyService->saveSurvey($form->getData(), $this->getUser(), $event, new \DateTimeImmutable());

            return $this->redirectToRoute('balticrobo_website_competitor_dashboard');
        }

        return $this->render('competitor/competition/survey.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }
}
