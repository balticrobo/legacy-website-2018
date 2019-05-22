<?php declare(strict_types=1);

namespace BalticRobo\Website\Controller\Judge\Registration;

use BalticRobo\Website\Form\Judge\RegistrationSearchType;
use BalticRobo\Website\Model\Judge\RegistrationSearchDTO;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Registration\EventHackathonRegistrationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/judge/registration/hackathon")
 * @Security("has_role('ROLE_JUDGE')")
 */
class HackathonController extends AbstractController
{
    private $eventService;
    private $eventRegistrationService;

    public function __construct(EventService $event, EventHackathonRegistrationService $eventRegistration)
    {
        $this->eventService = $event;
        $this->eventRegistrationService = $eventRegistration;
    }

    /**
     * @Route(methods={"GET"})
     *
     * @param Request $request
     */
    public function listAction(Request $request): Response
    {
        $event = $this->eventService->getCurrentEvent();

        $searchQuery = new RegistrationSearchDTO();
        $search = $this->createForm(RegistrationSearchType::class);
        $search->handleRequest($request);
        if ($search->isSubmitted() && $search->isValid()) {
            $searchQuery = $search->getData();
        }

        $records = $this->eventRegistrationService->getTeamsByEventWithFilter($searchQuery, $event);

        return $this->render('judge/registration/hackathon/list.html.twig', [
            'event' => $event,
            'search' => $search->createView(),
            'query' => $searchQuery,
            'records' => $records,
        ]);
    }

    /**
     * @Route("/{name}", methods={"GET"})
     *
     * @param string $name
     */
    public function detailsAction(string $name): Response
    {
        $event = $this->eventService->getCurrentEvent();
        $team = $this->eventRegistrationService->getTeamByName($name, $event);

        return $this->render('judge/registration/hackathon/details.html.twig', [
            'event' => $event,
            'team' => $team,
            'members' => $team->getMembers(),
        ]);
    }

    /**
     * @Route("/accept/member/{id}/{action}", requirements={"id": "\d+"}, methods={"POST"})
     *
     * @param int    $id
     * @param string $action
     */
    public function acceptMemberAction(int $id, string $action): Response
    {
        $member = $this->eventRegistrationService->getMemberById($id);
        $this->eventRegistrationService->setMember($member, $action, new \DateTimeImmutable());

        return $this->redirectToRoute('balticrobo_website_judge_registration_hackathon_details', [
            'name' => $member->getTeam()->getName(),
        ]);
    }
}
