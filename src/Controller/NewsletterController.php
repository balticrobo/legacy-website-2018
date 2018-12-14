<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Controller;

use BalticRobo\Website\Exception\Newsletter\InvalidIdentifierException;
use BalticRobo\Website\Exception\Newsletter\NewsletterNotFoundException;
use BalticRobo\Website\Form\Newsletter\NewsletterEmailType;
use BalticRobo\Website\Form\Newsletter\NewsletterIdType;
use BalticRobo\Website\Model\Newsletter\NewsletterIdDTO;
use BalticRobo\Website\Service\EventService;
use BalticRobo\Website\Service\NewsletterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/newsletter")
 */
final class NewsletterController extends AbstractController
{
    private $eventService;
    private $newsletterService;

    public function __construct(EventService $event, NewsletterService $newsletter)
    {
        $this->eventService = $event;
        $this->newsletterService = $newsletter;
    }

    /**
     * @Route(methods={"GET", "POST"})
     *
     * @param Request $request
     */
    public function optInAction(Request $request): Response
    {
        $form = $this->createForm(NewsletterEmailType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->newsletterService->optIn($form->getData(), new \DateTimeImmutable());

            return $this->render('newsletter/success.html.twig', [
                'event' => $this->eventService->getCurrentEvent(),
                'action' => 'opt_in',
            ]);
        }

        return $this->render('newsletter/opt_in.html.twig', [
            'form' => $form->createView(),
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }

    /**
     * @Route("/opt-out/{id}", methods={"GET"})
     *
     * @param string $id
     */
    public function optOutAction(string $id): Response
    {
        try {
            $dto = new NewsletterIdDTO();
            $dto->setId($id);
            if (!$this->newsletterService->isRegisteredForNewsletter($dto)) {
                throw new InvalidIdentifierException();
            }
        } catch (InvalidIdentifierException $e) {
            return $this->render('newsletter/invalid_identifier.html.twig', [
                'event' => $this->eventService->getCurrentEvent(),
            ]);
        }

        return $this->render('newsletter/opt_out.html.twig', [
            'form' => $form = $this->createForm(NewsletterIdType::class, $dto)->createView(),
            'event' => $this->eventService->getCurrentEvent(),
        ]);
    }

    /**
     * @Route("/opt-out", methods={"POST"})
     *
     * @param Request $request
     */
    public function optOutPOSTAction(Request $request): Response
    {
        $form = $this->createForm(NewsletterIdType::class);
        $form->handleRequest($request);
        try {
            $this->newsletterService->optOut($form->getData());
        } catch (NewsletterNotFoundException $e) {
            return $this->render('newsletter/invalid_identifier.html.twig', [
                'event' => $this->eventService->getCurrentEvent(),
            ]);
        }

        return $this->render('newsletter/success.html.twig', [
            'event' => $this->eventService->getCurrentEvent(),
            'action' => 'opt_out',
        ]);
    }
}
