<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Cms;

use BalticRobo\Website\Form\Cms\AddPartnerType;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\PartnerService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/cms/partner")
 * @Security("has_role('ROLE_CMS_USER')")
 */
class PartnerController extends Controller
{
    private $eventService;
    private $partnerService;

    public function __construct(EventService $event, PartnerService $partner)
    {
        $this->eventService = $event;
        $this->partnerService = $partner;
    }

    /**
     * @Route("/{page}", requirements={"page" = "\d+"}, defaults={"page" = 1})
     * @Method("GET")
     *
     * @param Request $request
     * @param int     $page
     *
     * @return Response
     */
    public function listAction(Request $request, int $page): Response
    {
        $limit = $request->query->getInt('limit', 20);

        return $this->render('cms/partner/list.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'records' => $this->partnerService->getList(($page - 1) * $limit, $limit),
            'total' => $this->partnerService->getTotal(),
        ]);
    }

    /**
     * @Route("/add")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_CMS_ADMIN')")
     *
     * @param Request $request
     */
    public function addAction(Request $request): Response
    {
        $event = $this->eventService->getCurrentEvent();

        $form = $this->createForm(AddPartnerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->partnerService->add($form->getData(), $event, new \DateTimeImmutable());

            return $this->redirectToRoute('balticrobo_website_cms_partner_list');
        }

        return $this->render('_common/form/admin_view.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }
}
