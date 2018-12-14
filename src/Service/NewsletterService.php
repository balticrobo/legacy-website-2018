<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

use BalticRobo\Website\Entity\Newsletter\Newsletter;
use BalticRobo\Website\Model\Newsletter\NewsletterEmailDTO;
use BalticRobo\Website\Model\Newsletter\NewsletterIdDTO;
use BalticRobo\Website\Repository\NewsletterRepository;
use Doctrine\Common\Collections\Collection;

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

    public function optOut(NewsletterIdDTO $dto): void
    {
        $entity = $this->newsletterRepository->getById($dto);
        $this->newsletterRepository->remove($entity);
    }

    public function isOptedInByEmail(string $email): bool
    {
        return $this->newsletterRepository->isOptedIn($email);
    }

    public function isRegisteredForNewsletter(NewsletterIdDTO $dto): bool
    {
        return $this->newsletterRepository->isRegisteredForNewsletter($dto);
    }

    public function getList(int $skip, int $take): Collection
    {
        return $this->newsletterRepository->getRecords($skip, $take);
    }

    public function getTotal(): int
    {
        return $this->newsletterRepository->getTotal();
    }
}
