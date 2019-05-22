<?php declare(strict_types=1);

namespace BalticRobo\Website\Repository\Registration;

use BalticRobo\Website\Entity\Event\Event;
use BalticRobo\Website\Entity\Registration\Information;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;

class InformationRepository
{
    private $objectManager;
    private $repository;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->repository = $objectManager->getRepository(Information::class);
    }

    /**
     * @param Event $event
     *
     * @return Collection|Information[]
     */
    public function getInformationByEvent(Event $event): Collection
    {
        $records = $this->repository->findBy(['event' => $event]);

        return new ArrayCollection($records);
    }
}
