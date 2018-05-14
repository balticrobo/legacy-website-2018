<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Cms;

use BalticRobo\Website\Entity\Rule\Rule;
use BalticRobo\Website\Form\Cms\EditRuleType;
use BalticRobo\Website\Model\Cms\EditRuleDTO;
use BalticRobo\Website\Service\EventService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/cms/rule")
 * @Security("has_role('ROLE_CMS_USER')")
 */
class RuleController extends Controller
{
    private $eventService;

    public function __construct(EventService $event)
    {
        $this->eventService = $event;
    }

    /**
     * @Route
     * @Method("GET")
     *
     * @return Response
     */
    public function listAction(): Response
    {
        $event = $this->eventService->getCurrentEvent();

        return $this->render('cms/rule/list.html.twig', [
            'event' => $event,
            'rules' => $this->eventService->getRulesByEvent($event),
        ]);
    }

    /**
     * @Route("/{id}/edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_CMS_ADMIN')")
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function editAction(Request $request, int $id): Response
    {
        $rule = $this->eventService->getRuleById($id);
        $dto = EditRuleDTO::createFromEntity($rule);
        $form = $this->createForm(EditRuleType::class, $dto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->eventService->updateRule(Rule::createFromEditDTO($rule, $form->getData(), new \DateTimeImmutable()));

            return $this->redirectToRoute('balticrobo_website_cms_rule_list');
        }

        return $this->render('_common/form/admin_view.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'form' => $form->createView(),
        ]);
    }
}
