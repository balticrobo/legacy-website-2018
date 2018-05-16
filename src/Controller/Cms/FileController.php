<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller\Cms;

use BalticRobo\Website\Form\Cms\AddFileType;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\Storage\FileService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/cms/file")
 * @Security("has_role('ROLE_CMS_USER')")
 */
class FileController extends Controller
{
    private $eventService;
    private $fileService;

    public function __construct(EventService $event, FileService $file)
    {
        $this->eventService = $event;
        $this->fileService = $file;
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

        return $this->render('cms/file/list.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'files' => $this->fileService->getList(($page - 1) * $limit, $limit),
            'total' => $this->fileService->getTotal(),
        ]);
    }

    /**
     * @Route("/add")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     */
    public function addAction(Request $request): Response
    {
        $form = $this->createForm(AddFileType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->fileService->upload($form->getData(), new \DateTimeImmutable());

            return $this->redirectToRoute('balticrobo_website_cms_file_list');
        }

        return $this->render('_common/form/admin_view.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'form' => $form->createView(),
        ]);
    }
}
