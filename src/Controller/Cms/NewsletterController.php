<?php declare(strict_types=1);

namespace BalticRobo\Website\Controller\Cms;

use BalticRobo\Website\Entity\Newsletter\Newsletter;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\NewsletterService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/cms/newsletter")
 * @Security("has_role('ROLE_CMS_USER')")
 */
final class NewsletterController extends AbstractController
{
    private const CSV_DELIMITER = ';';

    private $eventService;
    private $newsletterService;
    private $router;

    public function __construct(EventService $event, NewsletterService $newsletter, RouterInterface $router)
    {
        $this->eventService = $event;
        $this->newsletterService = $newsletter;
        $this->router = $router;
    }

    /**
     * @Route("/{page}", requirements={"page": "\d+"}, defaults={"page": 1}, methods={"GET"})
     *
     * @param Request $request
     * @param int     $page
     */
    public function listAction(Request $request, int $page): Response
    {
        $limit = $request->query->getInt('limit', 20);

        return $this->render('cms/newsletter/list.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'records' => $this->newsletterService->getList(($page - 1) * $limit, $limit),
            'total' => $this->newsletterService->getTotal(),
        ]);
    }

    /**
     * @Route("/csv", methods={"GET"})
     */
    public function csvListAction(): Response
    {
        $now = new \DateTimeImmutable();
        $data = $this->newsletterService->getList(0, PHP_INT_MAX);

        $response = new StreamedResponse();
        $response->setCallback(function () use ($data) {
            $handle = fopen('php://output', 'w+');
            fputcsv($handle, ['Email', 'Data dolaczenia', 'Unsubscribe link'], self::CSV_DELIMITER);
            $data->map(function (Newsletter $newsletter) use ($handle) {
                $optOutLink = $this->router->generate('balticrobo_website_newsletter_optout', [
                    'id' => $newsletter->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL);
                fputcsv($handle, array_merge($newsletter->getCsvRecord(), [$optOutLink]), self::CSV_DELIMITER);
            });
            fclose($handle);
        });
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', sprintf(
            'attachment; filename="%s"',
            "bbr_newsletter_participants_{$now->getTimestamp()}.csv"
        ));

        return $response;
    }
}
