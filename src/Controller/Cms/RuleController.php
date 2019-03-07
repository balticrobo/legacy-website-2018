<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Cms;

use BalticRobo\Website\Entity\Rule\Rule;
use BalticRobo\Website\Form\Cms\EditRuleType;
use BalticRobo\Website\Model\Cms\EditRuleDTO;
use BalticRobo\Website\Service\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms/rule")
 * @Security("has_role('ROLE_CMS_USER')")
 */
class RuleController extends AbstractController
{
    private $eventService;

    public function __construct(EventService $event)
    {
        $this->eventService = $event;
    }

    /**
     * @Route(methods={"GET"})
     */
    public function redirectToListAction(): Response
    {
        $event = $this->eventService->getCurrentEvent();

        return $this->redirectToRoute('balticrobo_website_cms_rule_list', [
            'eventYear' => $event->getYear(),
        ]);
    }

    /**
     * @Route("/{eventYear}", methods={"GET"})
     *
     * @param int $eventYear
     */
    public function listAction(int $eventYear): Response
    {
        $event = $this->eventService->getEventByYear($eventYear);

        return $this->render('cms/rule/list.html.twig', [
            'event' => $event,
            'records' => $this->eventService->getRulesByEvent($event),
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET", "POST"})
     * @Security("has_role('ROLE_CMS_ADMIN')")
     *
     * @param Request $request
     * @param int     $id
     */
    public function editAction(Request $request, int $id): Response
    {
        $rule = $this->eventService->getRuleById($id);
        $dto = EditRuleDTO::createFromEntity($rule);
        $form = $this->createForm(EditRuleType::class, $dto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->eventService->updateRule(Rule::createFromEditDTO($rule, $form->getData(), new \DateTimeImmutable()));

            return $this->redirectToRoute('balticrobo_website_cms_rule_list', [
                'eventYear' => $rule->getEventCompetition()->getEvent()->getYear(),
            ]);
        }

        return $this->render('_common/form/admin_view.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'form' => $form->createView(),
        ]);
    }
}
