<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

use BalticRobo\Website\Entity\Newsletter\Newsletter;
use BalticRobo\Website\Model\Newsletter\NewsletterEmailDTO;
use BalticRobo\Website\Repository\NewsletterRepository;

final class NewsletterService
{
    private $newsletterRepository;

    public function __construct(NewsletterRepository $newsletterRepository)
    {
        $this->newsletterRepository = $newsletterRepository;
    }

    public function optIn(NewsletterEmailDTO $dto, \DateTimeImmutable $now): void
    {
        $entity = Newsletter::createFromEmailDTO($dto, $now);
        $this->newsletterRepository->save($entity);
    }

    public function isOptedInByEmail(string $email): bool
    {
        return $this->newsletterRepository->isOptedIn($email);
    }
}
