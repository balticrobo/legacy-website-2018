<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Judge\Registration;

use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\VolunteerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/judge/registration/volunteer")
 * @Security("has_role('ROLE_JUDGE')")
 */
final class VolunteerController extends AbstractController
{
    private $eventService;
    private $volunteerService;

    public function __construct(EventService $event, VolunteerService $volunteer)
    {
        $this->eventService = $event;
        $this->volunteerService = $volunteer;
    }

    /**
     * @Route(methods={"GET"})
     *
     * @param Request $request
     */
    public function list(Request $request): Response
    {
        $event = $this->eventService->getCurrentEvent();
        $records = $this->volunteerService->getByEvent($event);

        return $this->render('judge/registration/volunteer/list.html.twig', [
            'event' => $event,
            'records' => $records,
        ]);
    }

    /**
     * @Route("/{id}/shirt/{day}/give", requirements={"id" = "\d+", "day" = "1|2"}, methods={"POST"})
     *
     * @param int $id
     * @param int $day
     */
    public function giveShirt(int $id, int $day): Response
    {
        $this->volunteerService->giveShirt($id, $day, new \DateTimeImmutable());

        return $this->redirectToRoute('balticrobo_website_judge_registration_volunteer_list', [
            '_fragment' => $id,
        ]);
    }

    /**
     * @Route("/{id}/shirt/{day}/take", requirements={"id" = "\d+", "day" = "1|2"}, methods={"POST"})
     *
     * @param int $id
     * @param int $day
     */
    public function takeShirt(int $id, int $day): Response
    {
        $this->volunteerService->takeShirt($id, $day);

        return $this->redirectToRoute('balticrobo_website_judge_registration_volunteer_list', [
            '_fragment' => $id,
        ]);
    }
}
